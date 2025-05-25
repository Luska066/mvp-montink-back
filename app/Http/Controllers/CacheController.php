<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cache;

use App\Interfaces\CrudInterface;
/**
 * @group Cache
*/
class CacheController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new Cache();
    }
}