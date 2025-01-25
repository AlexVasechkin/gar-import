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
        Schema::create('address_object_types', function (Blueprint $table) {
            $table->id();
            $table->integer('level');
            $table->string('name');
            $table->string('shortname');
            $table->string('desc');
            $table->boolean('is_active');
            $table->date('update_date');
            $table->date('start_date'); 
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_object_types');
    }
};
