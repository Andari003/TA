<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VideoFile extends Model
{
    use HasFactory;

    public function videoable(): MorphTo
    {
        return $this->morphTo();
    }
}
