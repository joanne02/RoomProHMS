<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255',
            
                function($attribute,$value,$fail){
                    $allowedDomain = 'example.com';
                    if(!str_ends_with($value, '@'. $allowedDomain)){
                        $fail('Please use siswa email');
                    }
                }
            ],
            'password' => ['required','confirmed', Rules\Password::defaults()],
        ];
    }
}
