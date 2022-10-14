<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateClubRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'name' => 'required',
            'cost_per_check_in' => 'required|numeric'
        ];
    }
}
