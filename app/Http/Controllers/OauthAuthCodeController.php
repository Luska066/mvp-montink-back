<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OauthAuthCode;

use App\Interfaces\CrudInterface;
/**
 * @group OauthAuthCode
*/
class OauthAuthCodeController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new OauthAuthCode();
    }
}