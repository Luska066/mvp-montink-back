<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProdutoVarianteEstoque;

use App\Interfaces\CrudInterface;
/**
 * @group ProdutoVarianteEstoque
*/
class ProdutoVarianteEstoqueController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new ProdutoVarianteEstoque();
    }
}