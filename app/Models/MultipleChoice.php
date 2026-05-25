<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static where(string $string, $id)
 */
class MultipleChoice extends Model
{
    protected $fillable = [
        'worksheet_id',
        'content'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(Worksheet::class);
    }
}

