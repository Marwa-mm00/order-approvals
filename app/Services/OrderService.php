<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderService
{
    public function createOrder(array $orderData, array $items): Order
    {
        if (empty($items)) {
            throw new Exception('An order must have at least one item.');
        }

        return DB::transaction(function () use ($orderData, $items) {
            $orderData['order_number'] = OrderNumberGenerator::generate();
            $orderData['total'] = $this->calculateTotal($items);
            $orderData['customer_name'] = $orderData['customer_name'] ?? 'Guest';
            $orderData['status'] = 'pending';
            $order = Order::create($orderData);

            foreach ($items as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }

            Log::info('Order created successfully: ' . $order->order_number);

            return $order;
        });
    }

    public function approveOrder(Order $order): Order
    {
        if ($order->status === 'approved') {
            throw new Exception('Approved orders cannot be modified.');
        }

        if ($order->total <= 1000) {
            throw new Exception('Orders below or equal to $1000 do not require approval.');
        }

        return DB::transaction(function () use ($order) {
            $order->status = 'approved';
            $order->save();

            Log::info('Order approved successfully: ' . $order->order_number);

            return $order;
        });
    }

    public function trackStatus(Order $order, string $status): void
    {
        $order->history()->create([
            'status' => $status,
            'changed_at' => now(),
        ]);

        Log::info('Order status updated: ' . $order->order_number . ' to ' . $status);
    }

    public function updateOrder(Order $order, array $validated): Order
    {
        if ($order->status === 'approved') {
            throw new Exception('Approved orders cannot be modified.');
        }

        return DB::transaction(function () use ($validated, $order) {
            $total = 0;
            if (isset($validated['customer_name'])) {
                $order->customer_name = $validated['customer_name'];
            }

            if (isset($validated['items'])) {
                $order->items()->delete();
                foreach ($validated['items'] as $item) {
                    $order->items()->create($item);

                }
                $total = $this->calculateTotal($validated['items']);
            }
            $order->total = $total;
            $order->save();

            return $order->load('items');
        });
    }

    private function calculateTotal(array $items): float
    {
        return array_reduce($items, function ($total, $item) {
            return $total + ($item['quantity'] * $item['price']);
        }, 0);
    }
}