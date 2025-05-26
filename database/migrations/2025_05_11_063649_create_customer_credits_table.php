<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_customer_credits', function (Blueprint $table) {
            $table->id('customer_credit_id');
            $table->unsignedBigInteger('customer_credit_customer_id');
            $table->unsignedBigInteger('customer_credit_sales_id');
            $table->string('customer_credit_invoice');
            $table->double('customer_credit_total_purchase');
            $table->double('customer_credit_total_payment');
            $table->double('customer_credit');
            $table->boolean('customer_credit_status');
            $table->dateTime('customer_credit_payment_date')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('customer_credit_customer_id')
                ->references('customer_id')
                ->on('tbl_customers');
            $table->foreign('customer_credit_sales_id')
                ->references('sales_id')
                ->on('tbl_sales');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_customer_credits');
    }
};
