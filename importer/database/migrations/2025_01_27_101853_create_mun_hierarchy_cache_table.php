<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mun_hierarchy_cache', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('name');
            $table->string('address', 500)->nullable();
            $table->unsignedBigInteger('last_address_object_id')->nullable();

            $table->primary(['id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mun_hierarchy_cache');
    }
};
