<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_purchase_details', function (Blueprint $table) {
            $table->id('purchase_detail_id');
            $table->unsignedBigInteger('purchase_detail_purchase_id');
            $table->unsignedBigInteger('purchase_detail_stock_id');
            $table->integer('purchase_detail_quantity');
            $table->double('purchase_detail_price');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_purchase_details');
    }
};
