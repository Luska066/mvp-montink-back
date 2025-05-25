<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoVarianteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'produto_id' => 'required|string',
  'imagem' => 'required|string',
  'nome' => 'required|string',
  'preco' => 'required|string',
);
    }
}
