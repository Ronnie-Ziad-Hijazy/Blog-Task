<?php

namespace App\Http\Requests;

class PostRequest extends BaseApiRequest
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
            'title' => ['required' , 'string' , 'max:255'],
            'content' => ['required' , 'string'],
            'author' => ['required' , 'string'],
            'category_id' => ['required' , 'numeric' , 'exists:categories,id'],
        ];
    }
}
