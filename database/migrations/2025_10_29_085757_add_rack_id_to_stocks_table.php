<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('stock_rack_id')
                ->nullable()
                ->after('stock_category_id');

            $table->foreign('stock_rack_id')
                ->references('category_id')
                ->on('tbl_categories')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_stocks', function (Blueprint $table) {
            $table->dropForeign(['stock_rack_id']);
            $table->dropColumn('stock_rack_id');
        });
    }
};
