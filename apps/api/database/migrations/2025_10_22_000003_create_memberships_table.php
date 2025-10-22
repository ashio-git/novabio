<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('role_tenant', ['owner', 'admin', 'editor', 'marketplace', 'billing', 'readonly'])->default('editor');
            $table->foreignId('invited_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('state', ['pending', 'accepted', 'expired', 'revoked'])->default('pending');
            $table->timestamps();
            
            $table->unique(['tenant_id', 'user_id']);
            $table->index(['user_id', 'state']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
