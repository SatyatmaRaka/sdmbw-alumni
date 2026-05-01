<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlumniPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'alumni_pekerjaan';

    /**
     * Atribut yang dapat diisi massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alumni_id',
        'nama_perusahaan',
        'jabatan',
        'tahun_mulai',
        'tahun_selesai',
        'alamat_perusahaan',
        'is_current',
    ];

    /**
     * Type casting untuk attributes
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_current' => 'boolean',
    ];

    /**
     * Relasi ke model Alumni
     *
     * @return BelongsTo
     */
    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }
}
