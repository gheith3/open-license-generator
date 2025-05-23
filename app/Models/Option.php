<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'label',
        'value',
    ];

    /**
     * Get the question that owns the option.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the license scores for the option.
     */
    public function licenseScores()
    {
        return $this->hasMany(OptionLicenseScore::class);
    }
}
