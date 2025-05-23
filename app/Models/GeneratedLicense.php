<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class GeneratedLicense extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_name',
        'author',
        'license_template_id',
        'content',
        'slug',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($license) {
            $license->slug = Str::random(8);
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the license template that owns the generated license.
     */
    public function licenseTemplate()
    {
        return $this->belongsTo(LicenseTemplate::class);
    }
}
