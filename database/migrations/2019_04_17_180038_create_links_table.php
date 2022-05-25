<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('short_code')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->boolean('intree')->default(0);
            $table->string('label')->nullable();
            $table->string('bg_color')->nullable();
            $table->integer('order')->default(0);
            $table->text('original');
            $table->string('folder')->nullable();
            $table->string('file_name')->nullable();
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
        Schema::dropIfExists('links');
    }
}
