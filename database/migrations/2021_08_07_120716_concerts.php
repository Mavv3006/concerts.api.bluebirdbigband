<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Concerts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('places', function (Blueprint $table) {
            $table->unsignedInteger('plz');
            $table->string('name');
            $table->timestamps();
            $table->primary('plz');
        });
        DB::statement('alter table places add constraint plz_check check (plz>=10000 and plz<=99999)');

        Schema::create('concerts', function (Blueprint $table) {
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('place_street');
            $table->string('place_number', 5);
            $table->string('place_description');
            $table->string('organizer_description');
            $table->timestamps();
            $table->primary('date');
            $table->foreignId('band_id');
            $table->unsignedInteger('place_plz');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bands');
        Schema::dropIfExists('places');
        Schema::dropIfExists('concerts');
    }
}
