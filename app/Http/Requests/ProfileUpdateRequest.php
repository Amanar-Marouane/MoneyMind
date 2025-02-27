<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'salary' => ['required', 'integer', 'min:0'],
            'credit_date' => ['required', 'integer', 'min:1', 'max:31'],
            'saving_goal' => ['nullable', 'integer', 'min:0'],
            'budget' => ['required', 'integer', 'min:0'],
        ];
    }
}
