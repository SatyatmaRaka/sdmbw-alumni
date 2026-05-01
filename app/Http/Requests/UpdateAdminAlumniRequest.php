<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminAlumniRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $alumniId = $this->route('alumni')->id ?? null;

        return [
            'nama_lengkap'   => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'nisn'           => 'required|string|max:20|unique:alumni,nisn,' . $alumniId,
            'nipd'           => 'nullable|string|max:50',
            'angkatan_id'    => 'required|exists:angkatan,id',
            'tahun_lulus'    => 'required|numeric|digits:4',
            'alamat'         => 'nullable|string',
            'no_hp'          => 'nullable|string|max:20', // Change to string to allow spaces/plus
            'email'          => 'nullable|email|max:255',
            'harapan'        => 'nullable|string',
        ];
    }
}
