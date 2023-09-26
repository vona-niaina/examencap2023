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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('examen_id')
            ->nullable()
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            
            $table->foreignId('user_id')
            ->nullable()
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('salle_id')
            ->nullable()
            ->constrained()
            ->default(null)
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->string('numeroUniqueConvocation',20)->nullable();

            $table->string('reussitExamen',15)->default('En cours');

            // $table->integer('creditCandidat')->length(1)->default(2);

            $table->timestamps();

            //combinaison unique examen,salle,candidat
            $table->unique(['examen_id', 'user_id', 'salle_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscriptions');
    }
};
