<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Código do cupom (ex: DESCONTO10)
            $table->decimal('discount_amount', 10, 2)->nullable(); // Desconto fixo (em R$)
            $table->decimal('discount_percent', 5, 2)->nullable(); // Desconto em %
            $table->decimal('min_cart_value', 10, 2)->default(0); // Valor mínimo do carrinho
            $table->date('valid_from')->nullable(); // Início da validade
            $table->date('valid_until')->nullable(); // Fim da validade
            $table->boolean('active')->default(true); // Ativo?
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

