<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_stocks', function (Blueprint $table) {
            $table->id('stock_id');
            $table->string('stock_code', 50)->unique();
            $table->string('stock_name', 100);
            $table->unsignedBigInteger('stock_category_id');
            $table->string('stock_unit', 5);
            $table->double('stock_purchase_price');
            $table->double('stock_sale_price_1');
            $table->double('stock_sale_price_2');
            $table->double('stock_sale_price_3');
            $table->integer('stock_total')->default(0);
            $table->integer('stock_current')->default(0);
            $table->integer('stock_in')->default(0);
            $table->integer('stock_out')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('stock_category_id')
                ->references('category_id')->on('tbl_categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_stocks');
    }
};
