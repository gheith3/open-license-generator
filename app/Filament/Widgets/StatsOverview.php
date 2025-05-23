<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\LicenseTemplate;
use App\Models\GeneratedLicense;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Licenses', LicenseTemplate::query()->count()),
            Stat::make('Total Questions', LicenseTemplate::query()->count()),
            Stat::make('Total Users', User::query()->count()),
            Stat::make('Total Projects', GeneratedLicense::query()->count()),
        ];
    }
}
