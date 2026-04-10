<?php

namespace Tests\Feature;

use App\Models\ContactQuery;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_query_can_be_created(): void
    {
        $response = $this->postJson('/api/contact-queries', [
            'name' => 'Ajay Kumar',
            'email' => 'ajay@example.com',
            'phone' => '9999999999',
            'subject' => 'Need help',
            'message' => 'Please call me back.',
        ]);

        $response->assertCreated()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.email', 'ajay@example.com');

        $this->assertDatabaseHas('contact_queries', [
            'email' => 'ajay@example.com',
            'subject' => 'Need help',
        ]);
    }

    public function test_admin_analytics_returns_expected_summary_and_month_buckets(): void
    {
        $admin = User::factory()->create();
        Role::query()->firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->assignRole('admin');
        Sanctum::actingAs($admin);

        Product::query()->create([
            'name' => 'Kahwa Gold',
            'slug' => 'kahwa-gold',
            'status' => true,
        ]);

        $customer = User::factory()->create();
        Role::query()->firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        $customer->assignRole('customer');
        User::query()->whereKey($customer->id)->update([
            'created_at' => '2025-02-10 10:00:00',
            'updated_at' => '2025-02-10 10:00:00',
        ]);

        $query = ContactQuery::query()->create([
            'name' => 'Ravi',
            'email' => 'ravi@example.com',
            'message' => 'Need shipping details',
        ]);
        ContactQuery::query()->whereKey($query->id)->update([
            'created_at' => '2025-03-01 08:00:00',
            'updated_at' => '2025-03-01 08:00:00',
        ]);

        $deliveredOrder = Order::query()->create([
            'order_number' => 'ORD-1001',
            'user_id' => $admin->id,
            'subtotal' => 1000,
            'discount_amount' => 0,
            'shipping_amount' => 0,
            'total_amount' => 1000,
            'status' => 'delivered',
            'payment_status' => 'paid',
        ]);
        Order::query()->whereKey($deliveredOrder->id)->update([
            'created_at' => '2025-04-10 10:00:00',
            'updated_at' => '2025-04-10 10:00:00',
        ]);

        $cancelledOrder = Order::query()->create([
            'order_number' => 'ORD-1002',
            'user_id' => $admin->id,
            'subtotal' => 500,
            'discount_amount' => 0,
            'shipping_amount' => 0,
            'total_amount' => 500,
            'status' => 'cancelled',
            'payment_status' => 'failed',
        ]);
        Order::query()->whereKey($cancelledOrder->id)->update([
            'created_at' => '2025-05-10 10:00:00',
            'updated_at' => '2025-05-10 10:00:00',
        ]);

        $response = $this->getJson('/api/admin/analytics?year=2025&range=yearly');

        $response->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonCount(12, 'data.overview.labels')
            ->assertJsonPath('data.summary.total_revenue', 1000)
            ->assertJsonPath('data.summary.orders_completed', 1)
            ->assertJsonPath('data.summary.total_customers', 1)
            ->assertJsonPath('data.summary.total_active_products', 1)
            ->assertJsonPath('data.contact_queries.total', 1);
    }
}
