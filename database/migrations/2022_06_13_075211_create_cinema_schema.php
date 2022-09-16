<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /**
    # Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories
     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different locations

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('movies', function($table) {
            $table->id();
            $table->string('title');
            $table->json('cast')->nullable();
            $table->date("relase_date");
            $table->timestamps();
        });

        Schema::create('cinemas', function($table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string("country");
            $table->timestamps();
        });

        Schema::create('Seats', function($table) {
            $table->id();
            $table->foreignId('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
            $table->string('seat_number');
            $table->string('category');
            $table->double('pricing', 15, 8)->nullable()->default(123.4567);
            $table->timestamps();
        });

        Schema::create('cinema_seat', function($table) {
            $table->id();
            $table->foreignId('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
            $table->foreignId('seat_id')->references('id')->on('Seats')->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('shows', function($table) {
            $table->id();
            $table->foreignId('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
            $table->foreignId('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->dateTime('start')->nullable()->default(new DateTime());
            $table->dateTime('end')->nullable();
            $table->bigInteger('slot')->default(100);
            $table->timestamps();
        });

        Schema::create('user_ticket', function($table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('show_id')->references('id')->on('shows')->onDelete('cascade');
            $table->foreignId('seat_id')->references('id')->on('seats')->onDelete('cascade');
            $table->dateTime('start')->nullable()->default(new DateTime());
            $table->dateTime('end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
