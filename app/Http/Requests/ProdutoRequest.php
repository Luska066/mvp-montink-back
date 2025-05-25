<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array(
            'imagem' => $this->isMethod('post') ? 'required|image' : 'sometimes|image',
            'nome' => 'required|string',
            'preco' => 'required|string',
            'qtd' => 'required|string',
        );
    }
}
