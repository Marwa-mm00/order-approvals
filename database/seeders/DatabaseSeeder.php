<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=> bcrypt('12345678'),
        ]);

        // Seed orders manually
        for ($i = 1; $i <= 5; $i++) {
            $order = Order::create([
                'order_number' => 'ORD' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'total' => 0,
                'status' => 'pending',
            ]);

            $total = 0;

            for ($j = 1; $j <= 3; $j++) {
                $item = OrderItem::create([
                    'order_id' => $order->id,
                    'item_name' => 'Item ' . $j,
                    'quantity' => $j,
                    'price' => 10 * $j,
                ]);

                $total += $item->quantity * $item->price;
            }

            $order->update(['total' => $total]);
        }
    }
}
