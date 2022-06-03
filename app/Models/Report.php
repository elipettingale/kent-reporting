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

        if ($this->due_at <= today()->format('Y-m-d H:i:s')) {
            return Status::OVERDUE;
        }

        return Status::PENDING;
    }
}
