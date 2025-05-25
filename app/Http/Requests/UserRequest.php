<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'name' => 'required|string',
  'email' => 'required|string',
  'email_verified_at' => 'required|string',
  'password' => 'required|string',
  'remember_token' => 'required|string',
);
    }
}
