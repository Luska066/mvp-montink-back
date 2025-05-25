<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CacheLockRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'owner' => 'required|string',
  'expiration' => 'required|string',
);
    }
}
