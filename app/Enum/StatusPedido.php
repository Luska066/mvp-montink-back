<?php

namespace App\Enum;

enum StatusPedido:string
{
case CANCELADO = 'CANCELADO';
case PENDENTE = 'PENDENTE';
case FINALIZADO = 'FINALIZADO';
}
