<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'notify_to',
        'event_type',
        'is_read',
        'description',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'notify_to');
    }

    public function scopeAdminNotifications($query)
    {
        return $query->where('event_type', 'like', 'admin_%')->orderBy('created_at', 'desc');
    }
}
