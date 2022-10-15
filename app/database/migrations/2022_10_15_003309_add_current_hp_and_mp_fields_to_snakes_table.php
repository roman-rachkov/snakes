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
        Schema::table('snakes', function (Blueprint $table) {
            $table->integer('current_hp')->default(0);
            $table->integer('current_mp')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('snakes', function (Blueprint $table) {
            $table->dropColumn(['current_hp', 'current_mp']);
        });
    }
};
