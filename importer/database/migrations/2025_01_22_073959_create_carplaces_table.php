<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <CARPLACE ID="56904" OBJECTID="99545200" OBJECTGUID="8ea90872-9026-4a58-ab77-3248f2571a0c" CHANGEID="162848915" NUMBER="1" OPERTYPEID="10" PREVID="0" NEXTID="0" UPDATEDATE="2020-12-10" STARTDATE="2020-12-10" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="1" />
    public function up(): void
    {
        Schema::create('carplaces', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('object_id')->index();
            $table->uuid('object_guid');
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->unsignedInteger('number')->default(0)->index();
            $table->unsignedBigInteger('operation_type_id')->index();
            $table->unsignedBigInteger('prev_id')->default(0);
            $table->unsignedBigInteger('next_id')->default(0);
            $table->date('update_date')->useCurrent();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_actual')->index();
            $table->boolean('is_active')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carplaces');
    }
};
