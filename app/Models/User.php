<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'first_name',
    'last_name',
    'middle_initial',
    'suffix',
    'email',
    'phone',
    'license',
    'region',
    'province',
    'city',
    'password',
        'role',
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return Cache::remember('user_role_' . $this->id, now()->addHours(24), function () {
            return $this->role === 'admin';
        });
    }

    public function isDriver()
    {
        return Cache::remember('user_is_driver_' . $this->id, now()->addHours(24), function () {
            return $this->role === 'driver';
        });
    }

    public function isUser()
    {
        return Cache::remember('user_is_user_' . $this->id, now()->addHours(24), function () {
            return $this->role === 'user';
        });
    }

    public function routes()
    {
        return $this->hasMany(Route::class, 'driver_id')->with(['checkpoints']);
    }

    public function checkpoints()
    {
        return $this->hasMany(Checkpoint::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Clear role cache when user is updated
        static::updated(function ($user) {
            Cache::forget('user_role_' . $user->id);
            Cache::forget('user_is_driver_' . $user->id);
            Cache::forget('user_is_user_' . $user->id);
        });
    }
}
