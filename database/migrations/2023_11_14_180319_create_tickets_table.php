<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->boolean('status');
            $table->string('description')->nullable();
            $table->string('display_description')->nullable();
            $table->double('weekday_price')->nullable();
            $table->double('weekend_price')->nullable();
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->string('play_time');
            $table->integer('advance_payment')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('max_sale_per_order')->nullable();
            $table->integer('min_sale_per_order')->nullable();
            $table->boolean('pos')->nullable();
            $table->boolean('one_bill_per_item')->nullable();
            $table->boolean('sell_and_register_customer')->nullable();
            $table->boolean('order_locked')->nullable();
            $table->boolean('custom_price')->nullable();
            $table->boolean('print_as_ticket')->nullable();
            $table->boolean('print_tc_on_ticket')->nullable();
            $table->longText('btn_img')->nullable();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('term_and_condition_id')->nullable()->constrained('terms_and_conditions')->onDelete('cascade');
            $table->string('category_ids');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
