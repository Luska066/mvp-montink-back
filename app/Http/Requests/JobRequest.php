<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'queue' => 'required|string',
  'payload' => 'required|string',
  'attempts' => 'required|string',
  'reserved_at' => 'required|string',
  'available_at' => 'required|string',
);
    }
}
