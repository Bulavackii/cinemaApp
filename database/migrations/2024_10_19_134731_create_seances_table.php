<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('guest');
            $table->rememberToken();
            $table->timestamps();
        });

        // Create cinema halls table
        Schema::create('cinema_halls', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('rows');
            $table->integer('seats_per_row');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create seats table
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_hall_id')->constrained('cinema_halls')->onDelete('cascade');
            $table->integer('row');
            $table->integer('seat_number');
            $table->enum('type', ['regular', 'vip'])->default('regular');
            $table->timestamps();
        });

        // Create movies table
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('country');
            $table->string('genre');
            $table->integer('duration');
            $table->string('poster_url')->nullable();
            $table->timestamps();
        });

        // Create seances table
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_hall_id')->constrained('cinema_halls')->onDelete('cascade');
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('price_regular', 8, 2);
            $table->decimal('price_vip', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('seances');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('seats');
        Schema::dropIfExists('cinema_halls');
        Schema::dropIfExists('users');
    }
};
