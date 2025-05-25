<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProdutoVariante;

use App\Interfaces\CrudInterface;
/**
 * @group ProdutoVariante
*/
class ProdutoVarianteController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new ProdutoVariante();
    }
}