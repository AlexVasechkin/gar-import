<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <ITEM CHANGEID="90863104" OBJECTID="60856341" ADROBJECTID="d4acb1e5-f64b-413d-ac84-68980b6785ed" OPERTYPEID="20" NDOCID="17672823" CHANGEDATE="2017-12-17" />
    public function up(): void
    {
        Schema::create('change_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id')->default(0)->index();
            $table->uuid('address_object_id')->index();
            $table->unsignedBigInteger('operation_type_id')->default(0)->index();
            $table->unsignedBigInteger('ndoc_id')->default(0)->index();
            $table->date('change_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_history');
    }
};
