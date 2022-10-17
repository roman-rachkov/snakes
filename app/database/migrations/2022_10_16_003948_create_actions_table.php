<?php

use App\Enums\BattleActions;
use App\Models\Snake;
use App\Models\Turn;
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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Snake::class, 'caster_id');
            $table->foreignIdFor(Snake::class, 'target_id');
            $table->foreignIdFor(Turn::class);
            $table->enum('action', BattleActions::arrayValues());
            $table->integer('damage')->nullable();
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
        Schema::dropIfExists('actions');
    }
};
