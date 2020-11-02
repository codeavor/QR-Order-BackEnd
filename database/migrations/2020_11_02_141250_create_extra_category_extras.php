<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraCategoryExtras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_category_extras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('extra_id');
            $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
            $table->unsignedBigInteger('extra_category_id');
            $table->foreign('extra_category_id')->references('id')->on('extra_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_category_extras');
    }
}
