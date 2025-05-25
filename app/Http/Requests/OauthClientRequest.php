<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OauthClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'owner_type' => 'required|string',
  'owner_id' => 'required|string',
  'name' => 'required|string',
  'secret' => 'required|string',
  'provider' => 'required|string',
  'redirect_uris' => 'nullable|string',
  'grant_types' => 'nullable|string',
  'revoked' => 'required|string',
);
    }
}
