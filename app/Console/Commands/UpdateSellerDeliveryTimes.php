<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateSellerDeliveryTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sellers:update-delivery-times';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update average delivery times for all sellers based on order history';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting delivery time calculation...');
        
        $service = new \App\Services\AverageDeliveryTimeService();
        
        \App\Models\User::where('user_type', 'seller')->chunk(100, function ($sellers) use ($service) {
            foreach ($sellers as $seller) {
                $avg = $service->calculateForSeller($seller);
                if ($avg !== null) {
                    $this->line("Updated seller {$seller->username}: {$avg} mins");
                }
            }
        });

        $this->info('Delivery time calculation completed.');
    }
}
