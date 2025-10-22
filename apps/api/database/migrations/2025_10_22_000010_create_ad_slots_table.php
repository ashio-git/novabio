<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->foreignId('block_id')->constrained('links')->cascadeOnDelete();
            $table->string('position_hint')->nullable();
            $table->json('rules_json');
            $table->json('audience_metrics_json')->nullable();
            $table->timestamps();
            
            $table->index(['site_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_slots');
    }
};
