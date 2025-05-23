<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text',
        'type',
        'key',
    ];

    protected $casts = [
        'type' => QuestionType::class,
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}
