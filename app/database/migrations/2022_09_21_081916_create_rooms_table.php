<?php

use App\Enums\RoomMode;
use App\Enums\RoomStatus;
use App\Models\User;
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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid');
            $table->string('status')->default(RoomStatus::OPEN->value);
            $table->string('mode')->default(RoomMode::DEATHMATCH->value);
            $table->integer('max_players')->default(2);
            $table->foreignIdFor(User::class);
            $table->string('password')->nullable();
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
        Schema::dropIfExists('rooms');
    }
};
