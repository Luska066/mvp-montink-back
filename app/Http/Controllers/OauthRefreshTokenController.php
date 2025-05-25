<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OauthRefreshToken;

use App\Interfaces\CrudInterface;
/**
 * @group OauthRefreshToken
*/
class OauthRefreshTokenController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new OauthRefreshToken();
    }
}