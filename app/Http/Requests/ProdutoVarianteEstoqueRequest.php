<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoVarianteEstoqueRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'produto_variante_id' => 'required|string',
  'qtd' => 'required|string',
);
    }
}
