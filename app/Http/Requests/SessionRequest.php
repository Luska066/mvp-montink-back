<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'user_id' => 'required|string',
  'ip_address' => 'required|string',
  'user_agent' => 'nullable|string',
  'payload' => 'required|string',
  'last_activity' => 'required|string',
);
    }
}
