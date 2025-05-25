<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Coupon
 *
 * @property int $id
 * @property string $code
 * @property float|null $discount_amount
 * @property float|null $discount_percent
 * @property float $min_cart_value
 * @property Carbon|null $valid_from
 * @property Carbon|null $valid_until
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Coupon extends Model implements  CrudInterface
{
	protected $table = 'coupons';

	protected $casts = [
		'discount_amount' => 'float',
		'discount_percent' => 'float',
		'min_cart_value' => 'float',
		'valid_from' => 'datetime',
		'valid_until' => 'datetime',
		'active' => 'bool'
	];

	protected $fillable = [
		'code',
		'discount_amount',
		'discount_percent',
		'min_cart_value',
		'valid_from',
		'valid_until',
		'active'
	];

    protected $appends = ["valid"];

    public function getValidAttribute(){
        $hoje = now()->toDateString();
        return $this->active &&
            (!$this->valid_from || $this->valid_from <= $hoje) &&
            (!$this->valid_until || $this->valid_until >= $hoje);
    }

    public function isValid($subtotal)
    {
        $hoje = now()->toDateString();
        return $this->active &&
            (!$this->valid_from || Carbon::parse($this->valid_from)->lte($hoje)) &&
            (!$this->valid_until || Carbon::parse($this->valid_until)->gte($hoje)) &&
            $subtotal >= (floatval($this->min_cart_value) ?? 0);
    }

    public function calcularDesconto($subtotal)
    {
        if (!$this->isValid($subtotal)) {
            return 0;
        }

        if ($this->discount_percent) {
            return ($subtotal * $this->discount_percent) / 100;
        }

        return min($this->discount_amount ?? 0, $subtotal);
    }
}
