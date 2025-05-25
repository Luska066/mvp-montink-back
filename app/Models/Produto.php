<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Produto
 *
 * @property int $id
 * @property string $uuid
 * @property string $imagem
 * @property boolean $active
 * @property string $nome
 * @property float $preco
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $email
 * @property string $cep
 * @property string|null $estado
 * @property string|null $cidade
 * @property string|null $rua
 * @property string|null $numero
 * @property string|null $complemento
 *
 * @property Collection|PedidosItem[] $pedidos_items
 * @property Collection|ProdutoVariante[] $produto_variantes
 * @property Collection|ProdutosEstoque[] $produtos_estoques
 *
 * @package App\Models
 */
class Produto extends Model implements CrudInterface
{
	protected $table = 'produtos';

	protected $casts = [
		'preco' => 'float',
        'active' => 'boolean'
	];

	protected $fillable = [
		'uuid',
		'imagem',
		'nome',
		'preco',
        'active'
	];

    protected $appends = ['estoque'];

    public function getImagemAttribute()
    {
        $imagem = $this->attributes['imagem'] ?? null;
        return $imagem ? Storage::temporaryUrl($imagem, now()->addHour()) : null;
    }

    public function getEstoqueAttribute()
    {
        return $this->produtos_estoques->qtd;
    }

    public function pedidos_items()
    {
        return $this->hasMany(PedidosItem::class, 'pedido_id');
    }

    public function produto_variantes()
    {
        return $this->hasMany(ProdutoVariante::class);
    }

    public function produtos_estoques()
    {
        return $this->hasOne(ProdutosEstoque::class, 'produto_id', 'id');
    }

    public function decrementarEstoque($qtd)
    {
        $produtoEstoque = $this->produtos_estoques;
        $novaQuantidade = $produtoEstoque->qtd - $qtd;
        $produtoEstoque->qtd = floatval($novaQuantidade);
        $produtoEstoque->save();
    }
}


