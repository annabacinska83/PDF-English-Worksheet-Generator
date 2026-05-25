<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $worksheet_id)
 * @method static orderByRaw(string $string)
 */
class Worksheet extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'theme',
        'level'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fillInTheBlanks(): HasMany
    {
        return $this->hasMany(FillInTheBlank::class);
    }

    public function multipleChoices(): HasMany
    {
        return $this->hasMany(MultipleChoice::class);
    }

    public function matchThePairs(): HasMany
    {
        return $this->hasMany(MatchThePair::class);
    }
}
