<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_slot_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['fixed', 'auction', 'barter']);
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('min_bid', 10, 2)->nullable();
            $table->json('barter_rules')->nullable();
            $table->json('schedule_windows');
            $table->enum('status', ['active', 'paused', 'sold', 'expired'])->default('active');
            $table->timestamps();
            
            $table->index(['ad_slot_id', 'status']);
            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_listings');
    }
};
