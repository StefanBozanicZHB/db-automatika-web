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
        Schema::create('dba_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_id');
            $table->date('date');
            $table->integer('account_number');
            $table->integer('type')->default(0); // 0 je usluga, 1 je licno
            $table->boolean('paid')->default(false);;
            $table->float('total',8,2)->nullable();
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
        Schema::dropIfExists('dba_orders');
    }
}
