<?php

namespace App\Filament\Resources\LicenseTemplateResource\Pages;

use App\Filament\Resources\LicenseTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLicenseTemplate extends EditRecord
{
    protected static string $resource = LicenseTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
