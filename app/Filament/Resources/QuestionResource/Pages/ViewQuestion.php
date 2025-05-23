<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;

class ViewQuestion extends ViewRecord
{
    protected static string $resource = QuestionResource::class;

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
