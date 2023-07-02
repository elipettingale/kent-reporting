<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Report extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'financial_year',
        'form_version'
    ];

    protected $casts = [
        'data' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function hasNotBeenSubmitted()
    {
        return $this->submitted_at === null;
    }

    public function status()
    {
        if ($this->submitted_at) {
            return Status::COMPLETE;
        }

        return Status::PENDING;
    }

    public function season()
    {
        return substr($this->financial_year - 1, 2, 2) . '/' . substr($this->financial_year, 2, 2);
    }

    public function scopeWhereStatus($query, $value)
    {
        if ($value === Status::COMPLETE) {
            return $query->whereNotNull('submitted_at');
        }

        if ($value === Status::PENDING) {
            return $query
                ->whereNull('submitted_at');
        }

        throw new \InvalidArgumentException("Status '{$value}' is invalid.");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getClubAttribute()
    {
        return $this->user->club;
    }
}
