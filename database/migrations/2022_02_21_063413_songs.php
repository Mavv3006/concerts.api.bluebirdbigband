<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Songs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Possible Types + folder names:
         * - concert recording + recordings
         * - playback + songs
         * */
        Schema::create('song_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('folder_name');
        });


        Schema::create('songs', function (Blueprint $table) {
            $table->string('file_name');
            $table->string('song_name');
            $table->string('genre');
            $table->string('arranger');
            $table->double('size');
            $table->foreignId('type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
