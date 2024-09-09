<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
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
            'event_name'=>['string'],
            'event_description'=>['string'],
            'countrey'=>['string'],
            'state'=>['string'],
            'street'=>['string'],
            'place'=>['string'],
            'event_type'=>['string',Rule::in(['medical','cultural','sport','technical','scientific','artistic','entertaining','commercial'])],
            'start_date'=>['date'],
            'end_date'=>['date'],
            'tickets_number'=>['integer'],
            'ticket_price'=>['numeric'],
            'is_done'=>['nullable','string'],
            'organization_id'=>['string'],
            'admin_id'=>['nullable']
        ];
    }
}
