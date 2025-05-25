<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProdutosEstoque;

use App\Interfaces\CrudInterface;
/**
 * @group ProdutosEstoque
*/
class ProdutosEstoqueController extends Controller implements  CrudInterface
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new ProdutosEstoque();
    }
}
