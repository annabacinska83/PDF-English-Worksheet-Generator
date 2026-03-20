<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MultipleChoice extends Model
{
    protected $fillable = [
      'content'
    ];

    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(Worksheet::class);
    }
}

