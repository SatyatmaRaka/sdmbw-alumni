<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
    /**
     * Sanitize nested array inputs sebelum validasi dijalankan.
     * ConvertEmptyStringsToNull middleware tidak menelusuri nested array,
     * sehingga kita perlu membersihkannya secara manual.
     */
    protected function prepareForValidation(): void
    {
        $pendidikan = collect($this->input('pendidikan', []))->map(function ($edu) {
            return array_map(fn($v) => ($v === '' ? null : $v), $edu);
        })->toArray();

        $pekerjaan = collect($this->input('pekerjaan', []))->map(function ($job) {
            return array_map(fn($v) => ($v === '' ? null : $v), $job);
        })->toArray();

        $this->merge([
            'pendidikan' => $pendidikan,
            'pekerjaan'  => $pekerjaan,
        ]);
    }

    public function rules(): array
    {
        return [
            'alamat'                      => 'required|string',
            'no_hp'                       => 'required|numeric|digits_between:10,14',
            'show_no_hp'                  => 'nullable|in:0,1',
            'email'                       => 'nullable|email|max:255',
            'harapan'                     => 'nullable|string|max:500',
            // Kita kembali menggunakan image rule karena finfo sekarang aktif
            'foto'                        => 'nullable|image|max:2048',
            'pendidikan.*.jenjang'        => 'nullable|string|max:50',
            'pendidikan.*.nama_instansi'  => 'nullable|string|max:255',
            'pendidikan.*.fakultas'       => 'nullable|string|max:255',
            'pendidikan.*.program_studi'  => 'nullable|string|max:255',
            'pendidikan.*.tahun_masuk'    => 'nullable|integer|digits:4',
            'pendidikan.*.tahun_lulus'    => 'nullable|integer|digits:4',
            'pendidikan.*.is_ongoing'     => 'nullable|in:0,1',
            'pekerjaan.*.nama_perusahaan' => 'nullable|string|max:255',
            'pekerjaan.*.jabatan'         => 'nullable|string|max:255',
            'pekerjaan.*.tahun_mulai'     => 'nullable|integer|digits:4',
            'pekerjaan.*.is_current'      => 'nullable|in:0,1',
            'username'                    => 'nullable|string|min:4|max:50|unique:users,username,' . auth()->id(),
            'password'                    => 'nullable|string|min:8|confirmed',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'alamat.required'         => 'Alamat wajib diisi',
            'no_hp.required'          => 'Nomor HP wajib diisi',
            'no_hp.numeric'           => 'Nomor HP harus berupa angka',
            'no_hp.digits_between'    => 'Nomor HP harus 10-14 digit',
            'harapan.max'             => 'Pesan & Harapan maksimal 500 karakter',
            'foto.image'              => 'Format gambar tidak valid (harus JPG, PNG, WEBP, dll)',
            'foto.max'                => 'Ukuran foto maksimal 2MB',
        ];
    }
}
