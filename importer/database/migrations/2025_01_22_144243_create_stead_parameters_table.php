<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <PARAM ID="1339809819" OBJECTID="157075796" CHANGEID="469924894" CHANGEIDEND="0" TYPEID="8" VALUE="01:08:0202012:6" UPDATEDATE="2022-11-15" STARTDATE="2022-11-15" ENDDATE="2079-06-06" />
    public function up(): void
    {
        Schema::create('stead_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id')->default(0)->index();
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->unsignedBigInteger('change_id_end')->default(0)->index();
            $table->unsignedInteger('type_id')->default(0)->index();
            $table->string('value')->default(0)->index();
            $table->date('update_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stead_parameters');
    }
};
