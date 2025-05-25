<?php

namespace App\Service;

class PedidoService
{

    static function calcularFrete($valor)
    {
        if ($valor > 52 && $valor < 166.59) {
            return 15;
        } else if ($valor > 200) {
            return 0;
        } else {
            return 20;
        }
    }

}
