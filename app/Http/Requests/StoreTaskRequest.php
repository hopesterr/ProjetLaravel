<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'board_id'    => ['required', 'exists:boards,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['required', 'in:todo,in_progress,done'],
            'due_date'    => ['nullable', 'date', 'after_or_equal:today'],
            'tags'        => ['nullable', 'array'],
            'tags.*'      => ['exists:tags,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'Le titre de la tâche est obligatoire.',
            'status.in'         => 'Le statut sélectionné est invalide.',
            'due_date.after_or_equal' => 'La date d\'échéance ne peut pas être dans le passé.',
        ];
    }
}