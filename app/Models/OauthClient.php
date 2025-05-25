<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\CrudInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OauthClient
 *
 * @property string $id
 * @property string|null $owner_type
 * @property int|null $owner_id
 * @property string $name
 * @property string|null $secret
 * @property string|null $provider
 * @property string $redirect_uris
 * @property string $grant_types
 * @property bool $revoked
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OauthClient extends Model implements  CrudInterface
{
	protected $table = 'oauth_clients';
	public $incrementing = false;

	protected $casts = [
		'owner_id' => 'int',
		'revoked' => 'bool'
	];

	protected $hidden = [
		'secret'
	];

	protected $fillable = [
		'owner_type',
		'owner_id',
		'name',
		'secret',
		'provider',
		'redirect_uris',
		'grant_types',
		'revoked'
	];
}
