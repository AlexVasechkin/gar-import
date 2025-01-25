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
        Schema::create('address_objects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id')->default(0)->index();
            $table->uuid('object_guid')->index();
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->string('name')->default('')->index();
            $table->string('type_name')->default('')->index();
            $table->unsignedInteger('level')->default(0)->index();
            $table->unsignedBigInteger('operation_type_id')->default(0)->index();
            $table->unsignedBigInteger('prev_id')->default(0)->index();
            $table->unsignedBigInteger('next_id')->default(0)->index();
            $table->date('update_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_actual')->default(true)->index();
            $table->boolean('is_active')->default(true)->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_objects');
    }
};
