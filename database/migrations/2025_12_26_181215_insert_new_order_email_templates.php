<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $templates = [
            [
                'name' => 'Admin New Order Notification',
                'code' => 'admin_new_order',
                'for' => 'Admin',
                'banner' => null,
                'title' => 'New Order Alert',
                'subject' => 'New Order #[[order_number]] Placed - Action Required',
                'salutation' => 'Hello Admin,',
                'message_body' => '<p>A new order has been placed on your platform.</p>
<p><strong>Order Number:</strong> [[order_number]]<br>
<strong>Product:</strong> [[product_names]]<br>
<strong>Amount:</strong> [[total_price]]<br>
<strong>Payment Status:</strong> [[payment_status]]</p>
<p>Please check the admin dashboard for more details. If the payment is pending, please review and verify it.</p>',
                'button_level' => 'View Order',
                'button_link' => '[[site_url]]/admin/order',
                'footer_status' => true,
                'footer_body' => '<p>Thank you for managing the platform.</p>',
                'bottom_status' => true,
                'bottom_title' => 'Need Help?',
                'bottom_body' => '<p>Contact the support team if you have issues.</p>',
                'short_codes' => '[[full_name]], [[email]], [[order_number]], [[order_date]], [[site_title]], [[site_url]], [[product_names]], [[quantity]], [[total_price]], [[payment_status]], [[order_status]]',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Seller New Order Notification',
                'code' => 'seller_new_order',
                'for' => 'Seller',
                'banner' => null,
                'title' => 'You Have a New Order!',
                'subject' => 'New Order #[[order_number]] Received - Get Ready',
                'salutation' => 'Hello [[seller_name]],',
                'message_body' => '<p>You have received a new order for your product(s).</p>
<p><strong>Order Number:</strong> [[order_number]]<br>
<strong>Product:</strong> [[product_names]]<br>
<strong>Quantity:</strong> [[quantity]]</p>
<p>Please get ready to deliver the item(s). <strong>Note:</strong> Ensure the payment status is "Completed" or "Success" before delivering the item. If the payment is pending, please wait for confirmation.</p>',
                'button_level' => 'View Order',
                'button_link' => '[[site_url]]/sell',
                'footer_status' => true,
                'footer_body' => '<p>Happy Selling!</p>',
                'bottom_status' => true,
                'bottom_title' => 'Need Help?',
                'bottom_body' => '<p>Contact support if you have any questions.</p>',
                'short_codes' => '[[seller_name]], [[order_number]], [[product_names]], [[quantity]], [[total_price]], [[order_date]], [[site_title]], [[site_url]]',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('email_templates')->insert($templates);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('email_templates')->whereIn('code', ['admin_new_order', 'seller_new_order'])->delete();
    }
};
