<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('service_id')->nullable();
            $table->bigInteger('admin_id');
            $table->string('name')->default('Untitled');
            $table->string('cover_photo')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('show_on_home')->default(0)->comment('0 means do not show on home, 1 means show on home');
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
        Schema::dropIfExists('albums');
    }
}
