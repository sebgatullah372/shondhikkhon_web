<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('album_id');
            $table->string('cover_photo')->nullable();
            $table->string('name')->default('Untitled');
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 for inactive, 1 for active');
            $table->tinyInteger('show_on_home')->default(0)->comment('0 means do not show on home, 1 means show on home');
            $table->softDeletes();
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
        Schema::dropIfExists('galleries');
    }
}
