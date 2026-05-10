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
        Schema::create('issue_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('issue_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('created_by')->nullable();

            $table->date('return_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_returns');
    }
};
