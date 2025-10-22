<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->json('json_blocks');
            $table->json('theme_tokens')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('label')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            
            $table->index(['site_id', 'created_at']);
            $table->index(['site_id', 'is_published']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_versions');
    }
};
