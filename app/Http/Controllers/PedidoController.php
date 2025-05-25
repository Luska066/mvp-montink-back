<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pedido;

use App\Interfaces\CrudInterface;
/**
 * @group Pedido
*/
class PedidoController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new Pedido();
    }

    public function approve(Pedido $pedido)
    {
       $pedido->approve();
    }

    public function cancel(Pedido $pedido)
    {
        $pedido->cancel();
    }
}
