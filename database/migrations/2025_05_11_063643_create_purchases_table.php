<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_purchases', function (Blueprint $table) {
            $table->id('purchase_id');
            $table->string('purchase_invoice', 100)->unique();
            $table->unsignedBigInteger('purchase_supplier_id');
            $table->unsignedBigInteger('purchase_region_id');
            $table->text('purchase_description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('purchase_supplier_id')->references('supplier_id')->on('tbl_suppliers');
            $table->foreign('purchase_region_id')->references('region_id')->on('tbl_regions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_purchases');
    }
};
