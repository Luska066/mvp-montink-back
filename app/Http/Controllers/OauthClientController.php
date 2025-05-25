<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OauthClient;

use App\Interfaces\CrudInterface;
/**
 * @group OauthClient
*/
class OauthClientController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new OauthClient();
    }
}