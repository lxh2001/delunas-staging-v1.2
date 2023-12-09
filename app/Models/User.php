<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'email',
        'contact_number',
        'password',
        'address',
        'image_url',
        'user_type',
        'remember_token',
        'email_verified_at',
        'birthdate'
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

    protected $appends = [
        'full_name'
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

    public function getFullNameAttribute()
    {
        return $this->firstname . " " . $this->lastname;
    }

    public function doctorAvailabilities()
    {
        return $this->hasMany(DoctorAvailability::class, 'doctor_id');
    }

    public function unreadNotifications() : HasMany
    {
        return $this->hasMany(Notification::class, 'notify_to')->where('is_read', false);
    }

    public function notifications() : HasMany
    {
        return $this->hasMany(Notification::class, 'notify_to')->orderBy('created_at', 'desc');
    }

    // public function adminUnreadNotifications() : HasMany
    // {
    //     return $this->hasMany(Notification::class)
    //     ->where('is_read_by_admin', false);
    // }
}
