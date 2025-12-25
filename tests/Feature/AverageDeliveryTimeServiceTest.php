<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AverageDeliveryTimeServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_null_when_insufficient_orders()
    {
        $seller = \App\Models\User::factory()->create(['user_type' => 'seller']);
        $service = new \App\Services\AverageDeliveryTimeService();

        $result = $service->calculateForSeller($seller);

        $this->assertNull($result);
    }

    public function test_it_calculates_average_correctly()
    {
        $seller = \App\Models\User::factory()->create(['user_type' => 'seller']);
        
        // Create 5 orders with 60 mins delivery time each
        for ($i = 0; $i < 5; $i++) {
            \App\Models\Order::create([
                'seller_id' => $seller->id,
                'status' => \App\Enums\OrderStatus::Completed->value,
                'created_at' => now()->subMinutes(60),
                'updated_at' => now(),
            ]);
        }

        $service = new \App\Services\AverageDeliveryTimeService();
        $result = $service->calculateForSeller($seller);

        $this->assertEquals(60, $result);
        $this->assertEquals(60, $seller->fresh()->average_delivery_time);
    }

    public function test_it_ignores_incomplete_orders()
    {
        $seller = \App\Models\User::factory()->create(['user_type' => 'seller']);
        
        // 4 Completed
        for ($i = 0; $i < 4; $i++) {
            \App\Models\Order::create([
                'seller_id' => $seller->id,
                'status' => \App\Enums\OrderStatus::Completed->value,
                'created_at' => now()->subMinutes(60),
                'updated_at' => now(),
            ]);
        }
        
        // 1 Pending (should be ignored)
        \App\Models\Order::create([
            'seller_id' => $seller->id,
            'status' => \App\Enums\OrderStatus::Pending->value,
            'created_at' => now()->subMinutes(60),
        ]);

        $service = new \App\Services\AverageDeliveryTimeService();
        $result = $service->calculateForSeller($seller);

        $this->assertNull($result); // Only 4 valid orders
    }

}
