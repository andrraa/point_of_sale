<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_code', 20)->unique();
            $table->string('category_name', 50);
            $table->boolean('category_type');
            $table->integer('category_price_level')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_categories');
    }
};
