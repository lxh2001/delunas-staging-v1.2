<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'doctor_id',
        'appointment_id',
        'user_id',
        'rate',
        'message',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
