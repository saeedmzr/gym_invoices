<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateMembershipRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'club_id' => 'required|exists:clubs,id',
            'credits' => 'required|numeric',
            'start_at' => 'required',
            'expire_at' => 'required',
            'status' => 'required|in:Active,Cancelled',
        ];
    }
}
