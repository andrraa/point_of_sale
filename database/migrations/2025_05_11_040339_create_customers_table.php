<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->unsignedBigInteger('customer_category_id');
            $table->string('customer_name', 100);
            $table->text('customer_address')->nullable();
            $table->unsignedBigInteger('customer_region_id');
            $table->string('customer_phone_number', 50)->nullable();
            $table->string('customer_npwp_number', 50)->nullable();
            $table->double('customer_credit_limit')->default(0);
            $table->boolean('customer_status')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('customer_category_id')->references('category_id')
                ->on('tbl_categories');
            $table->foreign('customer_region_id')->references('region_id')
                ->on('tbl_regions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_customers');
    }
};
