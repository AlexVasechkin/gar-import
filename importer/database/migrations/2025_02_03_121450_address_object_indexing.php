<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('address_objects', function (Blueprint $table) {
            $table->dateTime('index_sent_at')->default('1970-01-01 00:00:00')->index();
            $table->dateTime('index_completed_at')->default('1970-01-01 00:00:00')->index();
        });
    }

    public function down(): void
    {
        Schema::dropColumns('address_objects', ['index_sent_at', 'index_completed_at']);
    }
};
