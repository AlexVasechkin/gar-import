<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <ITEM ID="23353" OBJECTID="27798556" PARENTOBJID="390" CHANGEID="42820268" OKTMO="79703000106" PREVID="0" NEXTID="0" UPDATEDATE="1900-01-01" STARTDATE="1900-01-01" ENDDATE="2079-06-06" ISACTIVE="1" PATH="11.95230407.3.390.27798556" />
    public function up(): void
    {
        Schema::create('mun_hierarchy', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id')->default(0)->index();
            $table->unsignedBigInteger('parent_object_id')->default(0)->index();
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->string('oktmo')->default('')->index();
            $table->unsignedBigInteger('prev_id')->default(0)->index();
            $table->unsignedBigInteger('next_id')->default(0)->index();
            $table->date('update_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->string('path')->default('')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mun_hierarchy');
    }
};
