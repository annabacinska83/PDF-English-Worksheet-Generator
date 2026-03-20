<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FillInTheBlank extends Model
{
    protected $fillable = [
        'options',
        'content'
    ];

    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(Worksheet::class);
    }

}
