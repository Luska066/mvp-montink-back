<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OauthDeviceCodeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'user_id' => 'required|string',
  'client_id' => 'required|string',
  'user_code' => 'required|string',
  'scopes' => 'nullable|string',
  'revoked' => 'required|string',
  'user_approved_at' => 'required|date_format:Y-m-d H:i:s',
  'last_polled_at' => 'required|date_format:Y-m-d H:i:s',
  'expires_at' => 'required|date_format:Y-m-d H:i:s',
);
    }
}
