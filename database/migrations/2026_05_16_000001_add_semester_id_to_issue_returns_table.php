<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('issue_returns', function (Blueprint $table) {
            $table->unsignedBigInteger('semester_id')->nullable()->after('issue_id');
        });

        DB::table('issue_returns')
            ->select('id', 'issue_id')
            ->orderBy('id')
            ->chunkById(100, function ($issueReturns) {
                foreach ($issueReturns as $issueReturn) {
                    $semesterId = null;

                    if ($issueReturn->issue_id) {
                        $semesterId = DB::table('issues')
                            ->where('id', $issueReturn->issue_id)
                            ->value('semester_id');
                    }

                    DB::table('issue_returns')
                        ->where('id', $issueReturn->id)
                        ->update(['semester_id' => $semesterId]);
                }
            });

        Schema::table('issue_returns', function (Blueprint $table) {
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issue_returns', function (Blueprint $table) {
            $table->dropForeign(['semester_id']);
            $table->dropColumn('semester_id');
        });
    }
};