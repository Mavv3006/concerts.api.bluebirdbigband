<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConcertRecordings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concert_recordings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('size');
            $table->date('concert_date');
            $table->timestamps();
        });
        // TODO: add foreign key to concerts.date
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concert_recordings');
    }
}
