<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
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
            "type" => 'required|string',
            "assigned_by" => 'required',
            "class_model_id" => 'required',
            "section_id" => 'required',
            "subject_id" => 'required',
            "assign_date" => 'required',
            "description" => 'required',
            "submission_date" => 'required',
            "marks" =>  'required|numeric|between:1,100',
        ];
    }
    public function messages()
    {
        return [
            'type.required' => 'Please enter type!',
            'assigned_by.required' => 'Please enter assigned by!',
            'class_model_id.required' => 'Please select class!',
            'section_id.required' => 'Please select section!',
            'subject_id.required' => 'Please select subject!',
            'assign_date.required' => 'Please select assign date!',
            'description.required' => 'Please select description!',
            'submission_date.required' => 'Please select submission date!',
            'marks.required' => 'Please enter marks!',
        ];
    }
}
