<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alias',
        'message',
        'user_id',
        'alumni_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}