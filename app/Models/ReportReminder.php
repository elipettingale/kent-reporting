<?php

namespace App\Models;

use App\Notifications\ReportReminderNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'financial_year'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function send()
    {
        $this->user->notify(new ReportReminderNotification($this));

        $this->sent_at = now();
        return $this->save();
    }
}
