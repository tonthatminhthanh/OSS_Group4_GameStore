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
        Schema::create("khieu_nai", function (Blueprint $table) {
            $table->id();
            $table->foreignId("khach_hang_id")->references("id")->on("users");
        });

        Schema::create("ctkn", function (Blueprint $table) {
            $table->foreignId("khieu_nai_id")->references("id")->on("khieu_nai");
            $table->foreignId("mat_hang_id")->references("id")->on("mat_hang");
            $table->string("mo_ta");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists("khieu_nai");
        Schema::dropIfExists("ctkn");
    }
};
