<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <HOUSE ID="11093" OBJECTID="1472973" OBJECTGUID="6143953a-e27d-40d9-88ee-df15b09af1a4" CHANGEID="4082543" HOUSENUM="12" HOUSETYPE="2" OPERTYPEID="10" PREVID="0" NEXTID="0" UPDATEDATE="2016-04-01" STARTDATE="2015-02-02" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="1" />
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id')->default(0)->index();
            $table->uuid('object_guid')->index();
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->string('house_number')->default(0)->index();
            $table->unsignedBigInteger('house_type_id')->default(0)->index();
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

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
