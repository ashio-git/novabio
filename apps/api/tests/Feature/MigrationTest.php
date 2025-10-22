<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_tables_exist(): void
    {
        $tables = [
            'tenants', 'users', 'memberships', 'plans', 'sites',
            'themes', 'site_versions', 'domains', 'links',
            'ad_slots', 'ad_listings', 'ad_orders',
            'payments', 'subscriptions', 'invoices',
            'analytics_events', 'webhooks', 'audit_logs', 'experiments'
        ];

        foreach ($tables as $table) {
            $this->assertTrue(
                Schema::hasTable($table),
                "Table {$table} does not exist"
            );
        }
    }

    public function test_seed_data_loads(): void
    {
        $this->seed();

        $this->assertDatabaseHas('plans', ['code' => 'free']);
        $this->assertDatabaseHas('plans', ['code' => 'pro']);
        $this->assertDatabaseHas('plans', ['code' => 'business']);
        $this->assertDatabaseHas('themes', ['slug' => 'default-light']);
        $this->assertDatabaseHas('users', ['email' => 'admin@novabio.dev']);
        $this->assertDatabaseHas('tenants', ['slug' => 'demo']);
    }
}
