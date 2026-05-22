<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('requisition_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('user_id') // who receives
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('issued_by') // store/admin
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('semester_id') // who receives
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('department_id') // who receives
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};