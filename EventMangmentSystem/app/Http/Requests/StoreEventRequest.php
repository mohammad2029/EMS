<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
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
            'event_name'=>['required','string'],
            'event_description'=>['required','string'],
            'countrey'=>['required','string'],
            'state'=>['required','string'],
            'street'=>['required','string'],
            'place'=>['required','string'],
            'event_type'=>['required','string',Rule::in(['medical','cultural','sport','technical','scientific','artistic','entertaining','commercial'])],
            'start_date'=>['required','date'],
            'end_date'=>['required','date'],
            'tickets_number'=>['required','integer'],
            'ticket_price'=>['required','numeric'],
            'is_done'=>['nullable','string'],
            'organization_id'=>['required','string'],
            'admin_id'=>['nullable']
        ];
    }
}
