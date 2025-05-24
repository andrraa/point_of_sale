<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_sales', function (Blueprint $table) {
            $table->id('sales_id');
            $table->string('sales_invoice', 100)->unique();
            $table->unsignedBigInteger('sales_customer_id');
            $table->string('sales_payment_type', 10);
            $table->double('sales_total_price');
            $table->double('sales_total_payment');
            $table->double('sales_total_change')->default(0);
            $table->integer('sales_discount')->default(0);
            $table->integer('sales_total_discount')->default(0);
            $table->smallInteger('sales_status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_sales');
    }
};
