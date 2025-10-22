<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['subpath', 'subdomain', 'custom']);
            $table->string('host')->unique();
            $table->enum('status', ['pending', 'active', 'failed'])->default('pending');
            $table->enum('acme_status', ['pending', 'issued', 'failed', 'expired'])->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            $table->index(['site_id', 'type']);
            $table->index(['host', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
