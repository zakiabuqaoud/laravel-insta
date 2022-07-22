<?php

namespace App\Models;

use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'content', 'user_id', 'media',
    ];

    protected $appends = [
        'is_deleted'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new PublishedScope);
    }

    public function getIsDeletedAttribute()
    {
        return !is_null($this->deleted_at);
    }

    public function scopeVisibility(Builder $builder, ...$values)
    {

        $builder->where(function($query) use($values) {
            foreach ($values as $value) {
                $query->orWhere('visibility', $value);
            }
        });

    }

    public function scopePublic(Builder $builder)
    {
        $builder->where('visibility', 'public');
    }

    public function scopeWithDraft(Builder $builder)
    {
        $builder->withoutGlobalScope(PublishedScope::class);
        //$builder->whereIn('status', ['published', 'draft']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // Related Model (Tag)
            'posts_tags',   // Pivot Table
            'post_id',      // Current Model FK in pivot table
            'tag_id',       // Related Model FK in pivot table
            'id',           // Current Model PK
            'id'            // Related Model PK
        );
    }

    public function likes()
    {
        return $this->morphToMany(User::class, 'likeable', 'likes');
    }
}
