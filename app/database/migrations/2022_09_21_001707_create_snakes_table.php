<?php

use App\Models\SnakeType;
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
        Schema::create('snakes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('experience')->default(0);
            $table->integer('strength');
            $table->integer('dexterity');
            $table->integer('endurance');
            $table->integer('intelligence');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(SnakeType::class);
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
        Schema::dropIfExists('snakes');
    }
};
