<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->boolean('play_time_till_close')->after('play_time')->nullable();
            $table->text('tc_on_ticket_description')->after('print_tc_on_ticket')->nullable();
        });
        Schema::table('ticket_guests', function (Blueprint $table) {
            $table->integer('condition')->after('age_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_guests', function (Blueprint $table) {
            $table->dropColumn('condition');
        });
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('play_time_till_close');
            $table->dropColumn('tc_on_ticket_description');
        });
    }
};
