<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OauthRefreshToken
 *
 * @property string $id
 * @property string $access_token_id
 * @property bool $revoked
 * @property Carbon|null $expires_at
 *
 * @package App\Models
 */
class OauthRefreshToken extends Model implements  CrudInterface
{
	protected $table = 'oauth_refresh_tokens';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'revoked' => 'bool',
		'expires_at' => 'datetime'
	];

	protected $fillable = [
		'access_token_id',
		'revoked',
		'expires_at'
	];
}
