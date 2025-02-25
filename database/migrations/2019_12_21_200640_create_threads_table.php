<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable()->unique();
            $table->string('title');
            $table->text('body');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('board_id')->index();
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->unsignedBigInteger('replies_count')->default(0);
            $table->unsignedBigInteger('best_reply_id')->nullable();
            //$table->foreign('best_reply_id')->references('id')->on('replies')->onDelete('set null');
            $table->boolean('locked')->default(false);
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
        Schema::dropIfExists('threads');
    }
}
