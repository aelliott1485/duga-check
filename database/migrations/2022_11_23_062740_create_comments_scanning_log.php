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
        Schema::create('comments_scanning_log', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('status');
            $table->timestamp('last')->nullable();
            $table->timestamp('difference')->nullable();
            $table->ipAddress('requestorIp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments_scanning_log');
    }
};
