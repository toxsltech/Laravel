<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_queue', function (Blueprint $table) {
            $table->id();
            $table->string('from_email', 128);
            $table->string('to_email', 128);
            $table->text('message');
            $table->string('subject')->nullable();
            $table->dateTime('date_published')->nullable();
            $table->dateTime('last_attempt')->nullable();
            $table->dateTime('date_sent')->nullable();
            $table->integer('attempts')->default('1');
            $table->integer('state_id')->default('1');
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
        Schema::dropIfExists('email_queue');
    }
}
