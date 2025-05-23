<?php

namespace App\Filament\Resources\LicenseTemplateResource\Pages;

use App\Filament\Resources\LicenseTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;

class ViewLicenseTemplate extends ViewRecord
{
    protected static string $resource = LicenseTemplateResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return static::$resource::infolist($infolist);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
