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
        Schema::create('issue_return_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('issue_return_id');
            $table->unsignedBigInteger('product_id');

            $table->integer('qty');
            $table->string('condition')->nullable();
            // good / damaged

            $table->timestamps();

            $table->foreign('issue_return_id')->references('id')->on('issue_returns')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_return_items');
    }
};
