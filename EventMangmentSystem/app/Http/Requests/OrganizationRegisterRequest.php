<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRegisterRequest extends FormRequest
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
            'email' => ['required', 'string',],
            'password' => ['required', 'string', 'min:8'],
            'name' => ['required', 'string'],
            'logo' => ['required', 'image', 'mimes:png,jpg'],
            'organization_description' => ['required', 'string'],
            'organization_type' => ['required', 'string'],
            'admin_id' => ['nullable'],
        ];
    }
}
