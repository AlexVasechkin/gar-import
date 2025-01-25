<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <STEAD ID="66505390" OBJECTID="158590397" OBJECTGUID="c2bba243-ac93-4662-aae3-e4534f8a7e1b" CHANGEID="499226907" NUMBER="58" OPERTYPEID="10" PREVID="0" NEXTID="0" UPDATEDATE="2023-04-13" STARTDATE="2023-04-13" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="1" />
    public function up(): void
    {
        Schema::create('steads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id')->default(0)->index();
            $table->string('object_guid')->index();
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->unsignedInteger('number')->default(0)->index();
            $table->unsignedInteger('operation_type_id')->default(0)->index();
            $table->unsignedBigInteger('prev_id')->default(0)->index();
            $table->unsignedBigInteger('next_id')->default(0)->index();
            $table->date('update_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_actual')->default(true);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('steads');
    }
};
