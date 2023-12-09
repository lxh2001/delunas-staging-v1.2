<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'doctor_id',
        'availability_id',
        'date_schedule',
        'start_time',
        'end_time',
        'service',
        'status',
        'feedback',
        'reason',
        'covidForm',
        'mqForm',
        'suggested_availability',
        'suggested_date',
        'reschedule_status',
        'slot_no'
    ];

    public function bookedUser() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
