<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OauthAccessToken;

use App\Interfaces\CrudInterface;
/**
 * @group OauthAccessToken
*/
class OauthAccessTokenController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new OauthAccessToken();
    }
}