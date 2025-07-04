<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_sale_details', function (Blueprint $table) {
            $table->id('sale_detail_id');
            $table->unsignedBigInteger('sale_detail_sales_id');
            $table->unsignedBigInteger('sale_detail_stock_id');
            $table->string('sale_detail_stock_code', 100);
            $table->string('sale_detail_stock_name', 150);
            $table->unsignedBigInteger('sale_detail_stock_category_id');
            $table->string('sale_detail_stock_category_name', 100);
            $table->string('sale_detail_stock_unit', 10)->default('PCS');
            $table->double('sale_detail_cost_price');
            $table->double('sale_detail_price');
            $table->integer('sale_detail_quantity');
            $table->double('sale_detail_total_price');
            $table->double('sale_detail_discount');
            $table->double('sale_detail_discount_amount');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_sale_details');
    }
};
