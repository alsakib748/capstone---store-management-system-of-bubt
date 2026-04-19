<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_purchases', function (Blueprint $table) {
            $table->string('tracking_no')->nullable()->after('date');
            $table->string('note_no')->nullable()->after('tracking_no');
            $table->string('file_upload')->nullable()->after('note_no');

            $table->foreignId('semester_id')->nullable()->after('file_upload')->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->after('semester_id')->constrained()->nullOnDelete();

            $table->string('color_number')->nullable()->after('department_id');
        });
    }

    public function down(): void
    {
        Schema::table('return_purchases', function (Blueprint $table) {
            $table->dropConstrainedForeignId('semester_id');
            $table->dropConstrainedForeignId('department_id');

            $table->dropColumn([
                'tracking_no',
                'note_no',
                'file_upload',
                'color_number',
            ]);
        });
    }
};

