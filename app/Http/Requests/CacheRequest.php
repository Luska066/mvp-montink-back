<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CacheRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'value' => 'required|string',
  'expiration' => 'required|string',
);
    }
}
