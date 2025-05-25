<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array(
            'code' => 'required|string',
            'discount_percent' => 'required|string',
            'min_cart_value' => 'required|string',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date',
        );
    }
}
