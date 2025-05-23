<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionLicenseScore extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'option_id',
        'license_template_id',
        'score',
    ];

    /**
     * Get the option that owns the score.
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    /**
     * Get the license template that owns the score.
     */
    public function licenseTemplate()
    {
        return $this->belongsTo(LicenseTemplate::class);
    }
}
