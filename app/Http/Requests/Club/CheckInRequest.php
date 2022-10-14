<?php

namespace App\Http\Requests\Club;

use Illuminate\Foundation\Http\FormRequest;

class CheckInRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'club_id' => 'required|exists:clubs,id',
        ];
    }
}
