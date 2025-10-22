<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->string('hypothesis');
            $table->json('variants');
            $table->json('metrics');
            $table->enum('status', ['draft', 'running', 'completed', 'stopped'])->default('draft');
            $table->timestamps();
            
            $table->index(['site_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiments');
    }
};
