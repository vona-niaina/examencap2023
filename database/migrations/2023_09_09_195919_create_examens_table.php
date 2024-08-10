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
        Schema::create('examens', function (Blueprint $table) {
            $table->id();
            $table->string('typeExamen', 10);
            $table->year('anneeExamen');
            $table->date('debutExamen');
            $table->date('finExamen');
            $table->date('debutInscription')->nullable();
            $table->date('finInscription')->nullable();
            $table->string('cloture')->default('0');

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
        Schema::dropIfExists('examens');
    }
};
