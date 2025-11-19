<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_supplier_stocks', function (Blueprint $table) {
            $table->id('ss_id');
            $table->string('ss_name', 255)->unique();
            $table->string('ss_phone', 100);
            $table->string('ss_address', 255)->nullable();
            $table->text('ss_description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_supplier_stocks');
    }
};
