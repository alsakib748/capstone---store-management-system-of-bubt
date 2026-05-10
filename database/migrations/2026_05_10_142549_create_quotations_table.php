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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();

            $table->string('quotation_no')->unique();

            $table->string('tracking_no')->nullable();

            $table->unsignedBigInteger('supplier_id')->nullable();

            $table->date('quotation_date');

            $table->decimal('subtotal', 15, 2)->default(0);

            $table->decimal('discount', 15, 2)->default(0);

            $table->decimal('grand_total', 15, 2)->default(0);

            $table->text('notes')->nullable();

            $table->unsignedBigInteger('created_by');

            $table->timestamps();

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('set null');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};