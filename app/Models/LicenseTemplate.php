<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseTemplate extends Model
{
    protected $fillable = [
        'name',
        'identifier',
        'content',
    ];

    /**
     * Get the license scores for the license template.
     */
    public function licenseScores()
    {
        return $this->hasMany(OptionLicenseScore::class);
    }

    /**
     * Get the generated licenses for the license template.
     */
    public function generatedLicenses()
    {
        return $this->hasMany(GeneratedLicense::class);
    }
}
