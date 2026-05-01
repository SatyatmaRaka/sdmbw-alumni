<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAlumniRequest extends FormRequest
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
            'nisn' => ['required', 'digits:10', 'unique:alumni,nisn'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'angkatan_id' => ['required', 'exists:angkatan,id'],
            'tahun_lulus' => ['required', 'integer', 'min:2010', 'max:' . (date('Y') + 1)],
            'username' => ['required', 'string', 'alpha_num', 'min:4', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.digits' => 'NISN harus terdiri dari tepat 10 digit angka.',
            'nisn.unique' => 'NISN ini sudah terdaftar sebelumnya.',
            'nama_lengkap.required' => 'Nama lengkap sesuai ijazah wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter.',
            'angkatan_id.required' => 'Angkatan wajib dipilih.',
            'angkatan_id.exists' => 'Angkatan yang dipilih tidak valid.',
            'tahun_lulus.required' => 'Tahun lulus wajib diisi.',
            'tahun_lulus.min' => 'Tahun lulus tidak valid.',
            'username.required' => 'Username wajib diisi.',
            'username.alpha_num' => 'Username hanya boleh terdiri dari huruf dan angka, tanpa spasi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.unique' => 'Username sudah digunakan oleh orang lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
