<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prch_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_number');
            $table->text('description');
            $table->string('title');
            $table->string('brand');
            $table->string('department');
            $table->integer('category_id');
            $table->integer('unit_id');
            $table->integer('hsn_code')->nullable();
            $table->string('service_type')->nullable();
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
        Schema::dropIfExists('prch_items');
    }
}
