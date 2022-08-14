<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subgoalid');
            $table->string('list1')->nullable();
            $table->string('list2')->nullable();
            $table->string('list3')->nullable();
            $table->string('list4')->nullable();
            $table->string('list5')->nullable();
            $table->tinyInteger('complete1')->default(0);
            $table->tinyInteger('complete2')->default(0);
            $table->tinyInteger('complete3')->default(0);
            $table->tinyInteger('complete4')->default(0);
            $table->tinyInteger('complete5')->default(0);
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
        Schema::dropIfExists('lists');
    }
}
