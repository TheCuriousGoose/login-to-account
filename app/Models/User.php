<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'availability'
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

    public function getProfileImage()
    {
        if ($this->hasMedia('profile')) {
            return $this->getMedia('profile')->first()->getUrl('converted');
        } else {
            return asset('imgs/defaut-pfp.jpg');
        }
    }

    public function saveProfilePicture($file)
    {
        $this->clearMediaCollection('profile');

        $this->addMedia($file)->toMediaCollection('profile');

        return $this->getMedia('profile')->first()->getUrl('converted');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('converted')
            ->fit(Fit::Contain, 500, 500)
            ->format('png')
            ->nonQueued();
    }
}
