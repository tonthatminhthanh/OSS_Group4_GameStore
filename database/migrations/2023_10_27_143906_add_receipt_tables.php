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
        Schema::create("don_hang", function (Blueprint $table) {
            $table->id();
            $table->foreignId("khach_hang_id")->references("id")->on("users");
        });

        Schema::create("ctdh", function (Blueprint $table) {
            $table->foreignId("don_hang_id")->references("id")->on("don_hang");
            $table->foreignId("mat_hang_id")->references("id")->on("mat_hang");
            $table->float("don_gia")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists("don_hang");
        Schema::dropIfExists("ctdh");
    }
};
