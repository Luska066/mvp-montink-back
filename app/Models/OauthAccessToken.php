<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OauthAccessToken
 *
 * @property string $id
 * @property int|null $user_id
 * @property string $client_id
 * @property string|null $name
 * @property string|null $scopes
 * @property bool $revoked
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $expires_at
 *
 * @package App\Models
 */
class OauthAccessToken extends Model  implements  CrudInterface
{
	protected $table = 'oauth_access_tokens';
	public $incrementing = false;

	protected $casts = [
		'user_id' => 'int',
		'revoked' => 'bool',
		'expires_at' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'client_id',
		'name',
		'scopes',
		'revoked',
		'expires_at'
	];
}
