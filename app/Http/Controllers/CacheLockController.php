<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CacheLock;

use App\Interfaces\CrudInterface;
/**
 * @group CacheLock
*/
class CacheLockController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new CacheLock();
    }
}