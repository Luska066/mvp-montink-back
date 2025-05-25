<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enum\StatusPedido;
use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pedido
 *
 * @property int $id
 * @property string $uuid
 * @property float $total
 * @property float $desconto
 * @property float $frete
 * @property string $status
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
 *
 * @package App\Models
 */
class Pedido extends Model implements CrudInterface
{
	protected $table = 'pedidos';

	protected $casts = [
		'total' => 'float',
		'desconto' => 'float',
		'frete' => 'float'
	];

	protected $fillable = [
		'uuid',
		'total',
		'desconto',
		'frete',
		'status',
		'email',
		'cep',
		'estado',
		'cidade',
		'rua',
		'numero',
		'complemento'
	];

	public function pedidos_items()
	{
		return $this->hasMany(PedidosItem::class);
	}

    public function approve()
    {
        $this->status = StatusPedido::FINALIZADO->value;
        $this->save();
    }

    public function cancel()
    {
        $this->status = StatusPedido::CANCELADO;
        $this->save();
    }
}
