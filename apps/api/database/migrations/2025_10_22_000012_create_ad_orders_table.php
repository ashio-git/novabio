<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('ad_listings')->cascadeOnDelete();
            $table->foreignId('buyer_tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->enum('status', ['pending', 'escrow', 'active', 'completed', 'disputed', 'refunded'])->default('pending');
            $table->json('schedule');
            $table->json('proofs')->nullable();
            $table->integer('rating')->nullable();
            $table->text('review')->nullable();
            $table->timestamps();
            
            $table->index(['listing_id', 'status']);
            $table->index(['buyer_tenant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_orders');
    }
};
