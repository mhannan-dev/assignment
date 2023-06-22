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
            'assign_date' => 'required|date',
            'submission_date' => 'required|date|after_or_equal:assign_date',
            "description" => 'required',
            "marks" =>  'required|numeric|between:1,100',
            'attachment' => 'required|mimes:jpeg,png,pdf|max:2048'
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
            'description.required' => 'Please write description!',
            'assign_date.required' => 'Please select assign date!',
            'submission_date.required' => 'Please select submission date!',
            'marks.required' => 'Please enter marks!',
            'attachment.required' => 'File Required!',
        ];
    }
}
