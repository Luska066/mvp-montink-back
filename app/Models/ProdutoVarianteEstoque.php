<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProdutoVarianteEstoque
 *
 * @property int $id
 * @property int $produto_variante_id
 * @property float $qtd
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property ProdutoVariante $produto_variante
 *
 * @package App\Models
 */
class ProdutoVarianteEstoque extends Model implements  CrudInterface
{
	protected $table = 'produto_variante_estoque';

	protected $casts = [
		'produto_variante_id' => 'int',
		'qtd' => 'float'
	];

	protected $fillable = [
		'produto_variante_id',
		'qtd'
	];

	public function produto_variante()
	{
		return $this->belongsTo(ProdutoVariante::class);
	}
}
