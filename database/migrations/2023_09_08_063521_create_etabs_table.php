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
        Schema::create('etabs', function (Blueprint $table) {
            $table->id();
            $table->string('codeEtab', 10)->unique();
            $table->string('nomEtab', 120)->unique(); 
            $table->integer('codeSecteurEtab')->length(1); 
            $table->integer('codeNiveauEtab')->length(1); 

            $table->foreignId('zap_id')
                  ->nullable()
                  ->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('set null');   

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
        Schema::dropIfExists('etabs');
    }
};
