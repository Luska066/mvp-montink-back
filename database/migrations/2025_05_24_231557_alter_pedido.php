<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos',function (Blueprint $table){
            $table->string('email');
            $table->string('cep');
            $table->string('estado')->nullable();
            $table->string('cidade')->nullable();
            $table->string('rua')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos',function (Blueprint $table){
            $table->dropColumn(['email','cep','estado','cidade','rua','numero','complemento']);
        });
    }
};
