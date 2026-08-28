<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        // Mengambil ID user dari parameter route URL (misal /admin/users/{user})
        $userId = $this->route('user') ? ($this->route('user')->id ?? $this->route('user')) : null;

        return [
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => 'nullable|min:8',
            'role_id' => 'required',
            'is_active' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama Wajib diisi.',
            'name.max'          => 'Maksimal panjang nama 100 karakter.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah digunakan.',
            'password.min'      => 'Password minimal :min karakter.',
            'role_id.required'  => 'Role wajib diisi.'
        ];
    }
}