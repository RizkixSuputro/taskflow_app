<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->restrictOnDelete();

            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->date('due_date');
            $table->string('priority', 20)->default('medium');
            $table->string('status', 20)->default('to_do');




            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_id', 'created_at', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
