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
        // <PARAM ID="18138" OBJECTID="1228" CHANGEID="3194" CHANGEIDEND="0" TYPEID="15" VALUE="0006" UPDATEDATE="2014-01-05" STARTDATE="1900-01-01" ENDDATE="2079-06-06" />
        Schema::create('address_object_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id');
            $table->unsignedBigInteger('change_id');
            $table->unsignedBigInteger('change_id_end')->default(0);
            $table->unsignedBigInteger('type_id');
            $table->string('value');
            $table->date('update_date');
            $table->date('start_date')->default('1900-01-01');
            $table->date('end_date')->default('2079-06-06');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_object_parameters');
    }
};
