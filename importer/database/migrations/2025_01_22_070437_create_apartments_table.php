<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <APARTMENT ID="29244" OBJECTID="1521782" OBJECTGUID="5798bf0b-5f4f-4731-91a2-440a1c6385fd" CHANGEID="4155266" NUMBER="0" APARTTYPE="2" OPERTYPEID="10" PREVID="0" NEXTID="0" UPDATEDATE="2017-11-14" STARTDATE="2017-11-14" ENDDATE="2079-06-06" ISACTUAL="1" ISACTIVE="1" />
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('object_id')->index();
            $table->uuid('object_guid')->index();
            $table->unsignedBigInteger('change_id')->nullable();
            $table->unsignedInteger('number')->default(0)->index();
            $table->unsignedBigInteger('apartment_type_id')->default(0)->index();
            $table->unsignedBigInteger('operation_type_id')->default(0)->index();
            $table->unsignedBigInteger('prev_id')->default(0);
            $table->unsignedBigInteger('next_id')->default(0);
            $table->date('update_date')->default('2017-11-14');
            $table->date('start_date')->default('2017-11-14');
            $table->date('end_date')->default('2079-06-06');
            $table->boolean('is_actual')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
