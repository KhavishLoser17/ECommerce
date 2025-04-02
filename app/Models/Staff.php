<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Staff extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'email',
        'phone',
        'working_hours',
        'department',
        'location',
        'role',
        'status',
        'profile_picture',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the URL for the profile picture.
     * This assumes you're storing the images in the storage/app/public/profile_pictures directory
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_images) {
            return asset('storage/' . $this->profile_picture);
        }
        return asset('images/default-profile.png'); // Default profile image
    }
}
