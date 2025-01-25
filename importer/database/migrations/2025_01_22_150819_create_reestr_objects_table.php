<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // <OBJECT OBJECTID="27926807" OBJECTGUID="7b94dbc4-a6c1-4ef4-a2c3-6dcf132b52ba" CHANGEID="595690408" ISACTIVE="1" LEVELID="10" CREATEDATE="2019-07-10" UPDATEDATE="2024-05-15" />
    public function up(): void
    {
        Schema::create('reestr_objects', function (Blueprint $table) {
            $table->id();
            $table->uuid('object_guid');
            $table->unsignedBigInteger('change_id')->default(0)->index();
            $table->unsignedInteger('level_id')->default(0)->index();
            $table->date('create_date')->nullable();
            $table->date('update_date')->nullable();
            $table->boolean('is_active')->default(true)->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reestr_objects');
    }
};
