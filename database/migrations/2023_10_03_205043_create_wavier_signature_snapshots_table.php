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
        Schema::create('wavier_signature_snapshots', function (Blueprint $table) {
            $table->id();
            $table->longText('signature_snapshot')->nullable();
            $table->boolean('status')->nullable();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('family_member_id')->constrained('family_members');
            $table->foreignId('wavier_snapshot_id')->constrained('wavier_snapshots');
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
        Schema::dropIfExists('wavier_signature_snapshots');
    }
};
