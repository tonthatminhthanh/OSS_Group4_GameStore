<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create("mat_hang", function (Blueprint $table) {
            $table->id();
            $table->string("ten_mat_hang");
            $table->float("don_gia");
            $table->foreignId("the_loai")->references("id")->on("the_loai");
            $table->string("mo_ta");
            $table->string("avatar");
            $table->foreignId("dev_id")->references("id")->on("dev_team");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists("mat_hang");
    }
};
