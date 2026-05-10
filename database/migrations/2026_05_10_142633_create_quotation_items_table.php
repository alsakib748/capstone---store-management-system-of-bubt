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
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id');

            $table->unsignedBigInteger('product_id');

            $table->string('product_name');

            $table->string('product_code')->nullable();

            $table->integer('qty')->default(0);

            $table->decimal('price', 15, 2)->nullable();

            $table->decimal('total', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('quotation_id')
                ->references('id')
                ->on('quotations')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};
