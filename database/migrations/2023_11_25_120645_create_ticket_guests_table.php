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
        Schema::create('ticket_guests', function (Blueprint $table) {
            $table->id();
            $table->integer('age_to');
            $table->integer('age_from');
            $table->integer('allowed_guests')->nullable();
            $table->foreignId('ticket_id')->nullable()->constrained('tickets')->onDelete('cascade');  
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
        Schema::dropIfExists('ticket_guests');
    }
};
