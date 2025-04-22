<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0.01',
        ]);

        try {
            $order = $this->orderService->createOrder(
                ['customer_name' => $validated['customer_name']],
                $validated['items']
            );

            return response()->json(['order' => $order], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function view(Order $order): JsonResponse
    {
        return response()->json(['order' => $order->load('items')]);
    }

    public function approve(Order $order): JsonResponse
    {
        try {
            $approvedOrder = $this->orderService->approveOrder($order);

            return response()->json(['order' => $approvedOrder]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function history(Order $order): JsonResponse
    {
        return response()->json(['history' => $order->history]);
    }
}