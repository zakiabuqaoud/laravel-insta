<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'bio', 'hour_rate', 'avatar',
    ];

    protected $appends = [
        'avatar_url', 'full_name'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function getFullNameAttribute()
    {
        if (!$this->first_name && !$this->last_name) {
            return $this->user->name;
        }
        return $this->first_name . ' ' . $this->last_name;
    }

    /*public function getFirstNameAttribute($value)
    {
        return strtoupper($value);
    }*/

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . $this->full_name;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
