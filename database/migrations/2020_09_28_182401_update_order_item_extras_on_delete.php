<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderItemExtrasOnDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_item_extras', function (Blueprint $table) {
            $table->dropForeign(['order_item_id']);
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');
            $table->dropForeign(['extra_id']);
            $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_item_extras', function (Blueprint $table) {
            $table->dropForeign(['order_item_id']);
            $table->foreign('order_item_id')->references('id')->on('order_items');
            $table->dropForeign(['extra_id']);
            $table->foreign('extra_id')->references('id')->on('extras');
        });
    }
}
