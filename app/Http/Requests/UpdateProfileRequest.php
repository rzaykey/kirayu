<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;
use App\Rules\CurrentPassword;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'current_password' => ['required', 'string', new CurrentPassword()],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
}