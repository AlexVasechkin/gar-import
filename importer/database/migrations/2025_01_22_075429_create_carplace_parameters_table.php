<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <PARAM ID="1537509370" OBJECTID="164762950" CHANGEID="605331476" CHANGEIDEND="0" TYPEID="8" VALUE="01:05:2900013:35175" UPDATEDATE="2024-10-23" STARTDATE="2024-10-23" ENDDATE="2079-06-06" />
    public function up(): void
    {
        Schema::create('carplace_parameters', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('object_id')->default(0)->index();
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->unsignedBigInteger('change_id_end')->default(0)->index();
            $table->unsignedBigInteger('type_id')->index();
            $table->string('value')->default('')->index();
            $table->date('update_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carplace_parameters');
    }
};
