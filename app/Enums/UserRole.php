<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case KEPALA_SEKOLAH = 'kepala_sekolah';
    case ALUMNI = 'alumni';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::KEPALA_SEKOLAH => 'Kepala Sekolah',
            self::ALUMNI => 'Alumni',
        };
    }
}
