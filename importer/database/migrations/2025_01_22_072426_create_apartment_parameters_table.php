<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <PARAM ID="613499604" OBJECTID="77962285" CHANGEID="115909470" CHANGEIDEND="0" TYPEID="13" VALUE="797010000010000018440577000000000" UPDATEDATE="2019-07-19" STARTDATE="2017-04-05" ENDDATE="2079-06-06" />
    public function up(): void
    {
        Schema::create('apartment_parameters', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('object_id')->index();
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->unsignedBigInteger('change_id_end')->default(0)->index();
            $table->unsignedBigInteger('type_id')->index();
            $table->string('value')->index();
            $table->date('update_date')->default(now());
            $table->date('start_date')->default('2017-04-05');
            $table->date('end_date')->default('2079-06-06');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartment_parameters');
    }
};
