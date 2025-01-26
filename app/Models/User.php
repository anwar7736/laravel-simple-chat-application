<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = ['profile_image_url'];

    public function getProfileImageUrlAttribute()
    {
        $folder_name = 'users';
        $file_name = $this->image;

        $path = public_path("storage/images/" . $folder_name . "/" . $file_name);

        if ($file_name && file_exists($path)) {
            return asset("storage/images/" . $folder_name . "/" . $file_name);
        }

        return asset("assets/img/avatar.png");
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function unread()
    {
        return $this->hasMany(Message::class, 'sender_id')->where([
            'receiver_id' => auth()->id(),
            'is_read' => 0
        ]);
    }
}
