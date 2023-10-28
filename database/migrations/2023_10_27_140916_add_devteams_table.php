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
        Schema::create("dev_team", function (Blueprint $table) {
            $table->id();
            $table->string("dev_name");
            $table->string("avatar");
        });

        Schema::create("the_loai", function (Blueprint $table) {
            $table->id();
            $table->string("name");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists("dev_team");
        Schema::dropIfExists("the_loai");
    }
};
