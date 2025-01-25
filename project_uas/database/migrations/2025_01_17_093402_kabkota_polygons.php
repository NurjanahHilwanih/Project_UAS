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
        Schema::create('kabkota_polygons', function (Blueprint $table){
            $table->id();
            $table->foreignId('kabkota_id')->constrained('kabkotas')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type_polygon', ['Polygon', 'MultiPolygon'])->default('Polygon');
            $table->longText('polygon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
