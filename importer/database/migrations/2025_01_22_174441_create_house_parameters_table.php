<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <PARAM ID="1393321241" OBJECTID="158993688" CHANGEID="504212995" CHANGEIDEND="0" TYPEID="8" VALUE="01:05:2900013:26183" UPDATEDATE="2023-05-29" STARTDATE="2023-05-29" ENDDATE="2079-06-06" />
    public function up(): void
    {
        Schema::create('house_parameters', function (Blueprint $table) {
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
        Schema::dropIfExists('house_parameters');
    }
};
