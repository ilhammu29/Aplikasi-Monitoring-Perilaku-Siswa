<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('perilaku', function (Blueprint $table) {
            $table->unsignedBigInteger('id_guru')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('perilaku', function (Blueprint $table) {
            $table->unsignedBigInteger('id_guru')->nullable(false)->change();
        });
    }
};
