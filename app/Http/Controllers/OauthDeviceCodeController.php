<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OauthDeviceCode;

use App\Interfaces\CrudInterface;
/**
 * @group OauthDeviceCode
*/
class OauthDeviceCodeController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new OauthDeviceCode();
    }
}