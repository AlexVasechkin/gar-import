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
        // <ITEM ID="2971585" OBJECTID="33158714" PARENTOBJID="2799" CHANGEID="50569986" REGIONCODE="1" PREVID="0" NEXTID="0" UPDATEDATE="1900-01-01" STARTDATE="1900-01-01" ENDDATE="2079-06-06" ISACTIVE="1" PATH="11.2157.2397.2799.33158714" />
        Schema::create('adm_hierarchy', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('object_id')->default(0)->index();
            $table->unsignedBigInteger('parent_object_id')->default(0)->index();
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->unsignedBigInteger('region_code')->default(0)->index();
            $table->unsignedBigInteger('area_code')->default(0)->index();
            $table->unsignedBigInteger('city_code')->default(0)->index();
            $table->unsignedBigInteger('place_code')->default(0)->index();
            $table->unsignedBigInteger('plan_code')->default(0)->index();
            $table->unsignedBigInteger('street_code')->default(0)->index();
            $table->unsignedBigInteger('prev_id')->default(0)->index();
            $table->unsignedBigInteger('next_id')->default(0)->index();
            $table->date('update_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->string('path')->default('')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_hierarchy');
    }
};
