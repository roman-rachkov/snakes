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
            $table->enum('status', RoomStatus::arrayValues())->default(RoomStatus::OPEN);
            $table->enum('mode', RoomMode::arrayValues())->default(RoomMode::DEATHMATCH);
            $table->integer('max_players')->default(2);
            $table->foreignIdFor(User::class);
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
