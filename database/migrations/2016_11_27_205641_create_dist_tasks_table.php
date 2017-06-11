<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dist_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->integer('description');
            $table->integer('priority');
            $table->integer('status');
            $table->integer('technologies');
            $table->text('TagProject');
            $table->integer('estimate');
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
        Schema::dropIfExists('dist_tasks');
    }
}
