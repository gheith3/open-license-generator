<?php

namespace App\Filament\Resources\GeneratedLicenseResource\Pages;

use App\Filament\Resources\GeneratedLicenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGeneratedLicense extends ViewRecord
{
    protected static string $resource = GeneratedLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
