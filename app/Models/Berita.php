<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
        'image',
        'views_count',
        'is_featured',
        'excerpt',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->title) . '-' . Str::random(5);
            }
            if (empty($berita->excerpt) && !empty($berita->content)) {
                $berita->excerpt = Str::limit(strip_tags($berita->content), 200, '...');
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('title') && !$berita->isDirty('slug')) {
                $berita->slug = Str::slug($berita->title) . '-' . Str::random(5);
            }
            if (empty($berita->excerpt) && !empty($berita->content)) {
                $berita->excerpt = Str::limit(strip_tags($berita->content), 200, '...');
            }
        });
    }
}

