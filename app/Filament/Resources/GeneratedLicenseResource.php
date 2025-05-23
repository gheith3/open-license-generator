<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use App\Models\LicenseTemplate;
use App\Models\GeneratedLicense;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GeneratedLicenseResource\Pages;
use App\Filament\Resources\GeneratedLicenseResource\RelationManagers;

class GeneratedLicenseResource extends Resource
{
    protected static ?string $model = GeneratedLicense::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('author')
                    ->searchable(),
                Tables\Columns\TextColumn::make('licenseTemplate.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('licenseTemplate.name')
                    ->options(LicenseTemplate::all()->pluck('name', 'id'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('License Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('project_name')
                            ->label('Project Name'),
                        Infolists\Components\TextEntry::make('author')
                            ->label('Author'),
                        Infolists\Components\TextEntry::make('licenseTemplate.name')
                            ->label('License Type'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                    ]),
                Infolists\Components\Section::make('License Content')
                    ->schema([
                        Infolists\Components\TextEntry::make('content')
                            ->markdown()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGeneratedLicenses::route('/'),
            'view' => Pages\ViewGeneratedLicense::route('/{record}'),
        ];
    }
}
