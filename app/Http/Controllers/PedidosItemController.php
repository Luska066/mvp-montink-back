<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PedidosItem;

use App\Interfaces\CrudInterface;
/**
 * @group PedidosItem
*/
class PedidosItemController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new PedidosItem();
    }
}