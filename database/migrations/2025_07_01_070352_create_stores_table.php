<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_store', function (Blueprint $table) {
            $table->id('store_id');
            $table->string('store_name', 50);
            $table->string('store_address', 150);
            $table->string('store_phone_number', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_store');
    }
};
