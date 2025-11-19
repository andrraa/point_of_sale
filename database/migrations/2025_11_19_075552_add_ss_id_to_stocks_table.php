<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('stock_ss_id')->nullable()
                ->after('stock_out');

            $table->foreign('stock_ss_id')
                ->references('ss_id')
                ->on('tbl_supplier_stocks')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_stocks', function (Blueprint $table) {
            $table->dropForeign(['stock_ss_id']);
            $table->dropColumn('stock_ss_id');
        });
    }
};
