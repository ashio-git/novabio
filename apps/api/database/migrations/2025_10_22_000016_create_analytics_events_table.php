<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['view', 'click', 'conversion']);
            $table->json('utm_json')->nullable();
            $table->string('geo_ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('ts')->useCurrent();
            
            $table->index(['site_id', 'type', 'ts']);
            $table->index(['ts']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
    }
};
