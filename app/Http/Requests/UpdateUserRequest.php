<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "type" => 'required',
            "name" => 'required',
            "email" => 'required',
            "password" => 'nullable|min:5|max:8',
        ];
    }
    public function messages()
    {
        return [
            'type.required' => 'Please select type!',
            'name.required' => 'Please enter name!',
            'email.required' => 'Please enter email!'
        ];
    }
}
