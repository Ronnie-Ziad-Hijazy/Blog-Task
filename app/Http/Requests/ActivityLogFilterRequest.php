<?php

namespace App\Http\Requests;

class ActivityLogFilterRequest extends BaseApiRequest
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
            'action_type' => ['nullable' , 'in:CREATE,READ,UPDATE,DELETE'],
            'entity_type' => ['nullable' , 'string'], // Post , Category
            'entity_id' => ['nullable' , 'numeric'],
            'sort' => ['nullable' , 'in:asc,desc'],
        ];
    }
}
