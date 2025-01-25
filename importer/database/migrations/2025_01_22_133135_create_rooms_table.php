<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <ROOM ID="481198" OBJECTID="45894603" OBJECTGUID="0f55f9cd-5295-46e6-89a8-0097c46e10d9" CHANGEID="152201901" NUMBER="2" ROOMTYPE="0" OPERTYPEID="30" PREVID="249089" UPDATEDATE="2020-06-18" STARTDATE="2020-06-18" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="0" />
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id')->default(0)->index();
            $table->uuid('object_guid')->index();
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->unsignedInteger('number')->default(0)->index();
            $table->unsignedInteger('room_type_id')->default(0)->index();
            $table->unsignedBigInteger('operation_type_id')->default(0)->index();
            $table->unsignedBigInteger('prev_id')->default(0)->index();
            $table->date('update_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_actual')->default(true)->index();
            $table->boolean('is_active')->default(true)->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
