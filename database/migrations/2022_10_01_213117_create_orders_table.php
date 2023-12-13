<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->double('price');
            $table->double('ship');
            $table->double('bounce')->default(0);
            $table->text('notes')->nullable();
            $table->integer('status')->default(0); //0 waitig //1 inway //2 done //3 cancel
            $table->dateTime('done_date')->nullable();
            $table->string('serial');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->on('cutsomers')->references('id')->onDelete('CASCADE');
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->foreign('delivery_id')->on('deliveries')->references('id')->onDelete('CASCADE');
            $table->unsignedBigInteger('user_create');
            $table->foreign('user_create')->on('users')->references('id')->onDelete('CASCADE');
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
        Schema::dropIfExists('orders');
    }
}
