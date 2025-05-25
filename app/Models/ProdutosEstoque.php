<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProdutosEstoque
 *
 * @property int $id
 * @property int $produto_id
 * @property float $qtd
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Produto $produto
 *
 * @package App\Models
 */
class ProdutosEstoque extends Model implements  CrudInterface
{
	protected $table = 'produtos_estoque';

	protected $casts = [
		'produto_id' => 'int',
		'qtd' => 'float'
	];

	protected $fillable = [
		'produto_id',
		'qtd'
	];

	public function produto()
	{
		return $this->belongsTo(Produto::class);
	}
}
