<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('BRL');
            $table->json('features_json');
            $table->json('limits_json');
            $table->boolean('active')->default(true);
            $table->timestamps();
            
            $table->index(['active', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
