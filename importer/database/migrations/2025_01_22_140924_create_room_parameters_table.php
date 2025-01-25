<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // <PARAM ID="596302727" OBJECTID="24942748" CHANGEID="38631541" CHANGEIDEND="0" TYPEID="13" VALUE="796304201010000003140031000000000" UPDATEDATE="2017-01-29" STARTDATE="2015-01-01" ENDDATE="2079-06-06" />
        Schema::create('room_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id')->default(0)->index();
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->unsignedBigInteger('change_id_end')->default(0)->index();
            $table->unsignedInteger('type_id')->default(0)->index();
            $table->string('value')->default('')->index();
            $table->date('update_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_parameters');
    }
};
