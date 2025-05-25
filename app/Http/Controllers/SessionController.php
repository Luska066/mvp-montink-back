<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Session;

use App\Interfaces\CrudInterface;
/**
 * @group Session
*/
class SessionController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new Session();
    }
}