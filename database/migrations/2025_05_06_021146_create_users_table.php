<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('full_name', 255);
            $table->string('username', 50)
                ->index('idx_username')
                ->unique();
            $table->string('password', 255);
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('user_role_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_role_id')
                ->references('role_id')
                ->on('tbl_roles');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_users');
    }
};
