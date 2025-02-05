<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnmpCommandsTable extends Migration
{
    public function up()
    {
        Schema::create('devicelinks_snmpcommands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('oid');
            $table->string('type', 2);
            $table->string('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('devicelinks_snmpcommands');
    }
}
