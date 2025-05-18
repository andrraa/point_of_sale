<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_suppliers', function (Blueprint $table) {
            $table->id('supplier_id');
            $table->string('supplier_code', 20)->unique();
            $table->string('supplier_name', 100);
            $table->string('supplier_address', 255);
            $table->unsignedBigInteger('supplier_region_id');
            $table->string('supplier_contact_person', 100)->nullable();
            $table->string('supplier_telepon_number', 100)->nullable();
            $table->string('supplier_handphone_number', 100)->nullable();
            $table->string('supploer_npwp_number', 100)->nullable();
            $table->string('supploer_last_buy', 100)->nullable();
            $table->double('supplier_first_debt')->default(0);
            $table->double('supplier_last_debt')->default(0);
            $table->double('supplier_purchase')->default(0);
            $table->double('supplier_payment')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('supplier_region_id')->references('region_id')->on('tbl_regions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_suppliers');
    }
};
