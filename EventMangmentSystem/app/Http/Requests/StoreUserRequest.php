<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'=>['required','string','max:55'],
'email'=>['required','string','max:155'],
'password'=>['required','string','max:55','min:8'],
'phone_number'=>['required','string','max:55'],
'user_image'=>['required','image','mimes:png,jpg'],
'countrey'=>['required','string','max:55'],
'state'=>['required','string','max:155'],
'admin_id'=>['required']
        ];
    }
}
