<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LicenseTemplateResource\Pages;
use App\Filament\Resources\LicenseTemplateResource\RelationManagers;
use App\Models\LicenseTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class LicenseTemplateResource extends Resource
{
    protected static ?string $model = LicenseTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'License Templates';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('License Details')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('identifier')
                                    ->required()
                                    ->unique(ignorable: fn($record) => $record)
                                    ->helperText('e.g., mit, gpl_3, apache_2')
                                    ->regex('/^[a-z0-9_]+$/')
                                    ->maxLength(50),
                            ]),
                    ]),

                Forms\Components\Section::make('License Content')
                    ->schema([
                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->rows(20)
                            ->helperText('Use {{ project_name }}, {{ year }}, {{ author }} as placeholders')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('identifier')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),

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
                Tables\Filters\SelectFilter::make('identifier')
                    ->options(LicenseTemplate::query()->pluck('identifier', 'identifier')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name'),
                                Infolists\Components\TextEntry::make('identifier')
                                    ->badge()
                                    ->color('success'),
                            ]),
                    ]),

                Infolists\Components\Section::make('License Content')
                    ->schema([
                        Infolists\Components\TextEntry::make('content')
                            ->markdown()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->dateTime(),
                                Infolists\Components\TextEntry::make('updated_at')
                                    ->dateTime(),
                            ]),
                    ])
                    ->collapsed(),
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
            'index' => Pages\ListLicenseTemplates::route('/'),
            'create' => Pages\CreateLicenseTemplate::route('/create'),
            'view' => Pages\ViewLicenseTemplate::route('/{record}'),
            'edit' => Pages\EditLicenseTemplate::route('/{record}/edit'),
        ];
    }
}
