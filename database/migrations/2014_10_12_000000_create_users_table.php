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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('prenom', 100);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            $table->date('dateNaissance')->nullable();
            $table->string('cinEnseignant', 12)->nullable();

            $table->string('photoIdentite')->nullable();

            // $table->foreignId('etab_id')
            //     ->nullable()
            //     ->constrained()
            //     ->onUpdate('cascade')
            //     ->onDelete('set null'); 

            $table->date('dateObtentionCAE')->nullable();
            $table->string('diplomeCAE')->nullable();

            $table->date('dateObtentionBacc')->nullable();
            $table->string('diplomeBacc')->nullable();
            
            $table->date('dateDePriseDeService')->nullable();
            $table->string('certificatAdministratif')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
