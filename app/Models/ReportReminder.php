<?php

namespace App\Models;

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

    public function send()
    {
        // todo: send email

        $this->sent_at = now();
        return $this->save();
    }
}
