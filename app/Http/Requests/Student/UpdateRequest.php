<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'sometimes|string|min:3|max:255',
            'class_id' => 'sometimes|exists:class_types,id',
            'phone' => 'sometimes|string|min:3|max:255',
            'parent_name' => 'sometimes|string|min:3|max:255',
            'date_of_birth' => 'sometimes|date',
            'address' => 'sometimes|string|min:3|max:255',
        ];
    }
}
