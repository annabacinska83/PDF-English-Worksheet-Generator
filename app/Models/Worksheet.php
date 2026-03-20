<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Worksheet extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'category',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fillInTheBlanks(): HasMany
    {
        return $this->hasOne(FillInTheBlank::class);
    }

    public function multipleChoices(): HasMany
    {
        return $this->hasOne(MultipleChoice::class);
    }



}
