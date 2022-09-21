<?php

use App\Models\SnakeType;
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
        Schema::create('snake_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('strength')->default(5);
            $table->integer('dexterity')->default(5);
            $table->integer('endurance')->default(5);
            $table->integer('intelligence')->default(5);
            $table->timestamps();
        });

        SnakeType::create([
            'name' => 'Работяга',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('snake_types');
    }
};
