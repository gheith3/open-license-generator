<?php

namespace App\Filament\Resources\LicenseTemplateResource\Pages;

use App\Filament\Resources\LicenseTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLicenseTemplates extends ListRecords
{
    protected static string $resource = LicenseTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
