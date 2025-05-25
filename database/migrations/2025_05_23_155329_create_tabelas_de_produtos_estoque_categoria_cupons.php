<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //        PRODUTO

        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('imagem');
            $table->string('nome');
            $table->float('preco');
            $table->timestamps();
        });
        Schema::create('produtos_estoque', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->float('qtd')->default(0);
            $table->timestamps();

            $table->foreign('produto_id')
                ->references('id')
                ->on('produtos')
                ->cascadeOnDelete();
        });

        //        VARITANTES
        Schema::create('produto_variantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->string('imagem');
            $table->string('nome');
            $table->float('preco');
            $table->timestamps();

            $table->foreign('produto_id')
                ->references('id')
                ->on('produtos')
                ->cascadeOnDelete();
        });
        Schema::create('produto_variante_estoque', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_variante_id');
            $table->float('qtd')->default(0);
            $table->timestamps();

            $table->foreign('produto_variante_id')
                ->references('id')
                ->on('produto_variantes')
                ->cascadeOnDelete();
        });

        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->float('total');
            $table->float('desconto')->default(0);
            $table->float('frete')->default(20);
            $table->enum('status', [
                \App\Enum\StatusPedido::CANCELADO->value,
                \App\Enum\StatusPedido::PENDENTE->value,
                \App\Enum\StatusPedido::FINALIZADO->value
            ])->default(\App\Enum\StatusPedido::PENDENTE->value);
            $table->timestamps();
        });
        Schema::create('pedidos_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('produto_id')->nullable();
            $table->unsignedBigInteger('produto_variante_id')->nullable();
            $table->float('preco');
            $table->float('qtd');
            $table->timestamps();

            // Pedidos ================================
            $table->foreign('pedido_id')
                ->references('id')
                ->on('pedidos')
                ->cascadeOnDelete();
            $table->foreign('produto_id')
                ->references('id')
                ->on('produtos')
                ->cascadeOnDelete();
            $table->foreign('produto_variante_id')
                ->references('id')
                ->on('produto_variantes')
                ->cascadeOnDelete();
        });

        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('uses');
            $table->timestamp('expired_at');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
        Schema::dropIfExists('produtos_estoque');
        Schema::dropIfExists('produto_variantes');
        Schema::dropIfExists('produto_variante_estoque');
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('pedidos_item');
        Schema::dropIfExists('cupons');
    }
};
