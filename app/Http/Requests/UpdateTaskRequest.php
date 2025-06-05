<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
            'title' => 'string|max:255',
            'is_done' => 'boolean',
            'creator_id' => '',
            /*
            'project_id' => [
                'nullable',
                Rule::exists('projects', 'id')
                    ->where('creator_id', auth()->id()),
            ]
            */
            'project_id' => Rule::in(auth()->user()->memberships->pluck('id')),
        ];
    }
}
