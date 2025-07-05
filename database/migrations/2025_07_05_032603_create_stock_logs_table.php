<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_stock_logs', function (Blueprint $table) {
            $table->id('stock_log_id');
            $table->unsignedBigInteger('stock_log_stock_id')
                ->index('idx_stock_log_id');
            $table->integer('stock_log_quantity');
            $table->text('stock_log_description')->nullable();
            $table->string('stock_log_status');
            $table->unsignedBigInteger('stock_log_user_id');
            $table->timestamps();

            $table->foreign('stock_log_stock_id')
                ->references('stock_id')
                ->on('tbl_stocks')
                ->onDelete('cascade');
            $table->foreign('stock_log_user_id')
                ->references('user_id')
                ->on('tbl_users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_stock_logs');
    }
};
