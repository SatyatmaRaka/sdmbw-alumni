<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $fillable = ['alumni_id', 'content', 'is_featured', 'is_active'];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
