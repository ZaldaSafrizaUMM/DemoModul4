<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'title',
        'type',
        'genre',
        'release_year',
        'synopsis',
    ];

    protected $casts = [
        'release_year' => 'integer',
    ];

    // Query Scope untuk pencarian judul (?search=...)
    public function scopeSearchTitle($query, $keyword)
    {
        if (!empty($keyword)) {
            return $query->where('title', 'like', '%' . $keyword . '%');
        }
        return $query;
    }

    // Relasi Many-to-Many ke User
    public function users()
    {
        return $this->belongsToMany(User::class, 'media_user')->withTimestamps();
    }
}