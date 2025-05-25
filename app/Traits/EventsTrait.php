<?php

namespace App\Traits;

use App\Interfaces\CrudInterface;
use App\Models\ProdutoVarianteEstoque;
use App\Service\FileStore;
use http\Exception\InvalidArgumentException;

trait EventsTrait
{
    public function beforeUpdate(CrudInterface $model): void
    {

    }

    public function afterUpdate(CrudInterface $model): void
    {

    }

    public function beforeStore(CrudInterface &$model)
    {

    }

    public function afterStore(CrudInterface $model): void
    {
    }

    public function beforeDestroy(CrudInterface $model): void
    {

    }

    public function afterDestroy(CrudInterface $model): void
    {

    }

    public function beforeIndex(array $models): void
    {

    }

    public function beforeShow(CrudInterface $models): void
    {

    }

}
