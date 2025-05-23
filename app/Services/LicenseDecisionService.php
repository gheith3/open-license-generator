<?php

namespace App\Services;

use App\Models\Option;
use App\Models\LicenseTemplate;

class LicenseDecisionService
{
    public function decide(array $selectedOptionIds): ?LicenseTemplate
    {
       
        $licenseScores = [];

        // Get all license templates and initialize scores
        $licenses = LicenseTemplate::all();
        foreach ($licenses as $license) {
            $licenseScores[$license->id] = 0;
        }

        $ids = array_map('intval', array_values($selectedOptionIds));
            // Load selected options and sum their license scores
        $options = Option::with('licenseScores')->whereIn('id', $ids)->get();

        foreach ($options as $option) {
            foreach ($option->licenseScores as $score) {
                $licenseScores[$score->license_template_id] += $score->score;
            }
        }

        // Get license with highest score
        $bestLicenseId = array_keys($licenseScores, max($licenseScores))[0];

        return LicenseTemplate::find($bestLicenseId);
    }
}
