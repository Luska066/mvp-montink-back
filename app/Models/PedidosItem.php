<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PedidosItem
 *
 * @property int $id
 * @property int $pedido_id
 * @property int|null $produto_id
 * @property int|null $produto_variante_id
 * @property float $preco
 * @property float $qtd
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Pedido $pedido
 * @property Produto|null $produto
 * @property ProdutoVariante|null $produto_variante
 *
 * @package App\Models
 */
class PedidosItem extends Model implements CrudInterface
{
	protected $table = 'pedidos_item';

	protected $casts = [
		'pedido_id' => 'int',
		'produto_id' => 'int',
		'produto_variante_id' => 'int',
		'preco' => 'float',
		'qtd' => 'float'
	];

	protected $fillable = [
		'pedido_id',
		'produto_id',
		'produto_variante_id',
		'preco',
		'qtd'
	];

//    protected $appends = ['produto_variante'];
//
//    public function getProdutoVarianteAttribute()
//    {
//        return $this->produto_variante()->first() ?? null;
//    }
	public function pedido()
	{
		return $this->belongsTo(Pedido::class);
	}

	public function produto()
	{
		return $this->belongsTo(Produto::class);
	}

	public function produto_variante()
	{
		return $this->belongsTo(ProdutoVariante::class);
	}
}
