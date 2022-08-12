<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubgoalsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subgoals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid');
            $table->bigInteger('goalid');
            $table->integer('subnumber')->unsigned();
            $table->string('title');
            $table->text('memo')->nullable();
            $table->tinyInteger('complete')->default(0);
            $table->date('complete_date')->nullable();
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
        Schema::dropIfExists('subgoals_tables');
    }
}
