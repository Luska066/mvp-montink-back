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
 * Class ProdutoVariante
 *
 * @property int $id
 * @property int $produto_id
 * @property string $imagem
 * @property string $nome
 * @property float $preco
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Produto $produto
 * @property Collection|PedidosItem[] $pedidos_items
 * @property Collection|ProdutoVarianteEstoque $produto_variante_estoques
 *
 * @package App\Models
 */
class ProdutoVariante extends Model implements CrudInterface
{
	protected $table = 'produto_variantes';

	protected $casts = [
		'produto_id' => 'int',
		'preco' => 'float'
	];

	protected $fillable = [
		'produto_id',
		'imagem',
		'nome',
		'preco'
	];

    protected $appends = ['color','estoque','quantidadeParaCompra'];
    public function getQuantidadeParaCompraAttribute()
    {
        return 1;
    }
    public function getImagemAttribute()
    {
        $imagem = $this->attributes['imagem'] ?? null;
        return $imagem ? Storage::temporaryUrl($imagem,now()->addHour()) : null;
    }
    public function getEstoqueAttribute()
    {
        return $this->produto_variante_estoques->qtd;
    }
    public function getColorAttribute()
    {
        return $this->attributes['nome'];
    }
    public function getNomeAttribute()
    {
        return $this->produto->nome;
    }

	public function produto()
	{
		return $this->belongsTo(Produto::class);
	}

	public function pedidos_items()
	{
		return $this->hasMany(PedidosItem::class);
	}

	public function produto_variante_estoques()
	{
		return $this->hasOne(ProdutoVarianteEstoque::class,'produto_variante_id','id');
	}

    public function decrementarEstoque($qtd): void
    {
        $produtoVarianteEstoque = $this->produto_variante_estoques;
        $novaQuantidade = $produtoVarianteEstoque->qtd - $qtd;
        $produtoVarianteEstoque->qtd = $novaQuantidade;
        $produtoVarianteEstoque->save();
    }
}
