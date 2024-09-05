<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required','string',],
'email'=>['required','string',],
'password'=>['required','string','min:8'],
'phone_number'=>['required','string',],
'user_image'=>['required','mimes:jpeg,png,jpg,gif','image'],
'countrey'=>['required','string',],
'state'=>['required','string',],
'admin_id' =>['nullable']
        ];
    }
}
