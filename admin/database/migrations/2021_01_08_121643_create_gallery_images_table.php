<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('gallery_id');
            $table->bigInteger('admin_id');
            $table->string('image_location');
            $table->text('image_caption')->nullable();
            $table->double('height')->nullable();
            $table->double('width')->nullable();
            $table->tinyInteger('image_type')->comment('0 for landscape, 1 for portrait')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 for inactive, 1 for active');
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
        Schema::dropIfExists('gallery_images');
    }
}
