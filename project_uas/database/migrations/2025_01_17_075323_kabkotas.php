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
        Schema::create('kabkotas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alt_name');
            $table->double('latitude');
            $table->double('longitude');
            $table->double('kepadatan_penduduk');
            $table->integer('sekolah_sma');
            $table->integer('rumah_sakit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kabkotas');
    }
};
