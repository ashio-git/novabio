<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Plans
        DB::table('plans')->insert([
            [
                'code' => 'free',
                'name' => 'Free',
                'price' => 0.00,
                'currency' => 'BRL',
                'features_json' => json_encode(['sites' => 1, 'links' => 10, 'analytics' => 'basic']),
                'limits_json' => json_encode(['sites' => 1, 'links_per_site' => 10]),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'pro',
                'name' => 'Pro',
                'price' => 29.90,
                'currency' => 'BRL',
                'features_json' => json_encode(['sites' => 5, 'links' => 'unlimited', 'analytics' => 'advanced', 'custom_domain' => true]),
                'limits_json' => json_encode(['sites' => 5, 'links_per_site' => -1]),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'business',
                'name' => 'Business',
                'price' => 99.90,
                'currency' => 'BRL',
                'features_json' => json_encode(['sites' => 'unlimited', 'links' => 'unlimited', 'analytics' => 'advanced', 'custom_domain' => true, 'marketplace' => true, 'team' => true]),
                'limits_json' => json_encode(['sites' => -1, 'links_per_site' => -1]),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed Default Theme
        DB::table('themes')->insert([
            'name' => 'Default Light',
            'slug' => 'default-light',
            'tokens_json' => json_encode([
                'colors' => [
                    'primary' => '#3b82f6',
                    'background' => '#ffffff',
                    'text' => '#1f2937',
                ],
                'fonts' => [
                    'heading' => 'Inter',
                    'body' => 'Inter',
                ],
                'spacing' => 'comfortable',
                'radius' => 'medium',
            ]),
            'is_default' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Super Admin User
        DB::table('users')->insert([
            'email' => 'admin@novabio.dev',
            'name' => 'Super Admin',
            'role_global' => 'super_admin',
            'status' => 'active',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Demo Tenant
        DB::table('tenants')->insert([
            'name' => 'Demo Workspace',
            'slug' => 'demo',
            'plan_id' => 1,
            'seats' => 1,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
