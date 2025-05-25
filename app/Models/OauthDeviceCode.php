<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OauthDeviceCode
 *
 * @property string $id
 * @property int|null $user_id
 * @property string $client_id
 * @property string $user_code
 * @property string $scopes
 * @property bool $revoked
 * @property Carbon|null $user_approved_at
 * @property Carbon|null $last_polled_at
 * @property Carbon|null $expires_at
 *
 * @package App\Models
 */
class OauthDeviceCode extends Model implements  CrudInterface
{
	protected $table = 'oauth_device_codes';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'revoked' => 'bool',
		'user_approved_at' => 'datetime',
		'last_polled_at' => 'datetime',
		'expires_at' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'client_id',
		'user_code',
		'scopes',
		'revoked',
		'user_approved_at',
		'last_polled_at',
		'expires_at'
	];
}
