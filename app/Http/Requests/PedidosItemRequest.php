<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidosItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'pedido_id' => 'required|string',
  'produto_variante_id' => 'required|string',
  'preco' => 'required|string',
  'qtd' => 'required|string',
);
    }
}
