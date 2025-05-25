<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OauthRefreshTokenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'access_token_id' => 'required|string',
  'revoked' => 'required|string',
  'expires_at' => 'required|date_format:Y-m-d H:i:s',
);
    }
}
