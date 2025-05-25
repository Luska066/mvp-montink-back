<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OauthAccessTokenRequest extends FormRequest
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
  'name' => 'required|string',
  'scopes' => 'nullable|string',
  'revoked' => 'required|string',
  'expires_at' => 'required|date_format:Y-m-d H:i:s',
);
    }
}
