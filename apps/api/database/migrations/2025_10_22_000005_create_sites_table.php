<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('handle')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('theme_id')->nullable()->constrained('themes')->nullOnDelete();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('visibility', ['public', 'private', 'unlisted'])->default('public');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['tenant_id', 'status']);
            $table->index(['handle', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
