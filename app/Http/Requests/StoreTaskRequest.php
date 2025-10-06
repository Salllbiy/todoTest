<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => ['sometimes', Rule::in(['pending', 'in_progress', 'done'])],
            'due_date' => 'nullable|date|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Необходимо указать название задачи',
            'title.min' => 'Название задачи должно содержать как минимум 3 символа',
            'status.in' => 'Статус должен быть одним из: pending, in_progress, done',
            'due_date.after_or_equal' => 'Указана неверная дата',
        ];
    }
}
