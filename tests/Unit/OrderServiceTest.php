<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    private OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = app(OrderService::class);
    }

    public function test_create_order_with_valid_data(): void
    {
        $orderData = ['customer_name' => 'John Doe'];
        $items = [
            ['item_name' => 'Item 1', 'quantity' => 2, 'price' => 50],
            ['item_name' => 'Item 2', 'quantity' => 1, 'price' => 100],
        ];

        $order = $this->orderService->createOrder($orderData, $items);

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'total' => 200]);
        $this->assertDatabaseCount('order_items', 2);
    }

    public function test_create_order_without_items_throws_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('An order must have at least one item.');

        $this->orderService->createOrder(['customer_name' => 'John Doe'], []);
    }

    public function test_approve_order_above_threshold(): void
    {
        $order = Order::factory()->create(['total' => 1500, 'status' => 'pending']);

        $approvedOrder = $this->orderService->approveOrder($order);

        $this->assertEquals('approved', $approvedOrder->status);
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'approved']);
    }

    public function test_approve_order_below_threshold_throws_exception(): void
    {
        $order = Order::factory()->create(['total' => 500, 'status' => 'pending']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Orders below or equal to $1000 do not require approval.');

        $this->orderService->approveOrder($order);
    }
}