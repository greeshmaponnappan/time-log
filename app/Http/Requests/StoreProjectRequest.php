<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'work_date'       => 'required|date|after_or_equal:today',
            'project'      => 'required|string',
            'task_description'=> 'required|string|max:500',
            'time_spent'      => ['required', 'regex:/^\d{2}:\d{2}$/'], // HH:MM format
        ];
    }
    public function messages(): array
    {
        return [
            'work_date.after_or_equal' => 'You cannot select a past date.',
            'time_spent.regex'          => 'Time must be in HH:MM format.',
        ];
    }
}
