<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->enum('provider', ['mercadopago'])->default('mercadopago');
            $table->enum('kind', ['subscription', 'oneoff', 'escrow']);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('BRL');
            $table->json('provider_refs');
            $table->enum('status', ['pending', 'processing', 'succeeded', 'failed', 'refunded'])->default('pending');
            $table->text('failure_reason')->nullable();
            $table->timestamps();
            
            $table->index(['tenant_id', 'status']);
            $table->index(['provider', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
