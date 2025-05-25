<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cupon
 *
 * @property int $id
 * @property string $code
 * @property int $uses
 * @property Carbon $expired_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Cupon extends Model implements  CrudInterface
{
	protected $table = 'cupons';

	protected $casts = [
		'uses' => 'int',
		'expired_at' => 'datetime'
	];

	protected $fillable = [
		'code',
		'uses',
		'expired_at'
	];
}
