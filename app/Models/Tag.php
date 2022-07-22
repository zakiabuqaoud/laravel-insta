<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function posts()
    {
        return $this->belongsToMany(
            Post::class,     // Related Model (Tag)
            'posts_tags',   // Pivot Table
            'tag_id',      // Current Model FK in pivot table
            'post_id',       // Related Model FK in pivot table
            'id',           // Current Model PK
            'id'            // Related Model PK
        );
    }
}
