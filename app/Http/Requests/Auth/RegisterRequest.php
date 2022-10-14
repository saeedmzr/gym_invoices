<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public mixed $phone;

    public function rules()
    {
        return [
            'phone' => 'required|numeric|digits:11',
            'password' => 'required|min:6|max:12'
        ];
    }
}
