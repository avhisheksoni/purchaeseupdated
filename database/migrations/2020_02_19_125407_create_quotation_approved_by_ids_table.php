<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationApprovedByIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_approved_by_ids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quotation_approval_id')->default('0');
            $table->string('approved_status')->nullable();
            $table->string('send_status')->nullable();
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
        Schema::dropIfExists('quotation_approved_by_ids');
    }
}
