<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('perilaku', function (Blueprint $table) {
        $table->integer('nilai')->nullable()->change();
    });
}

public function down()
{
    Schema::table('perilaku', function (Blueprint $table) {
        $table->integer('nilai')->nullable(false)->change();
    });
}
};
