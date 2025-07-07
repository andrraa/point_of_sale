<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_stock_takens', function (Blueprint $table) {
            $table->id('stock_taken_id');
            $table->unsignedBigInteger('stock_taken_stock_id');
            $table->string('stock_taken_stock_code');
            $table->string('stock_taken_stock_name');
            $table->integer('stock_taken_quantity');
            $table->double('stock_taken_price');
            $table->text('stock_taken_description')->nullable();
            $table->unsignedBigInteger('stock_taken_user_id');
            $table->unsignedBigInteger('stock_taken_category_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_stock_takens');
    }
};
