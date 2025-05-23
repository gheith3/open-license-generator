<?php

namespace App\Filament\Resources;

use App\Enums\QuestionType;
use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'Questions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Question Details')
                    ->schema([
                        Forms\Components\TextInput::make('text')
                            ->label('Question Text')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('type')
                            ->label('Question Type')
                            ->options(QuestionType::class)
                            ->required(),

                        Forms\Components\Repeater::make('options')
                            ->relationship('options')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('label')->required(),
                                        Forms\Components\TextInput::make('value')->required(),
                                    ])->columnSpanFull(),

                                Forms\Components\Repeater::make('licenseScores')
                                    ->relationship('licenseScores')
                                    ->label('License Scores')
                                    ->schema([
                                        Forms\Components\Select::make('license_template_id')
                                            ->relationship('licenseTemplate', 'name')
                                            ->label('License')
                                            ->required(),

                                        Forms\Components\TextInput::make('score')
                                            ->numeric()
                                            ->default(0)
                                            ->required()
                                            ->minValue(0)
                                            ->maxValue(10),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0),
                            ])->columnSpanFull(),


                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('text')
                    ->label('Question Text')
                    ->searchable()
                    ->limit(150),

                Tables\Columns\TextColumn::make('type')
                    ->searchable(),

                Tables\Columns\TextColumn::make('options_count')
                    ->label('Options')
                    ->counts('options')
                    ->badge(),

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
                //
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
                Infolists\Components\Section::make('Question Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('text')
                            ->label('Question Text'),

                        Infolists\Components\TextEntry::make('type'),
                    ]),

                Infolists\Components\RepeatableEntry::make('options')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('label'),
                                Infolists\Components\TextEntry::make('value'),
                                Infolists\Components\TextEntry::make('licenseScores.count')
                                    ->getStateUsing(fn($record) => $record->licenseScores->count()),
                            ]),

                        Infolists\Components\RepeatableEntry::make('licenseScores')
                            ->label('License Scores')
                            ->schema([
                                Infolists\Components\Grid::make(2)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('licenseTemplate.name')
                                            ->label('License'),
                                        Infolists\Components\TextEntry::make('score'),
                                    ]),
                            ]),
                    ])->columnSpanFull(),

                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->dateTime(),
                                Infolists\Components\TextEntry::make('updated_at')
                                    ->dateTime(),
                            ]),

                        Infolists\Components\RepeatableEntry::make('licenseScores')
                            ->label('License Scores')
                            ->schema([
                                Infolists\Components\Grid::make(2)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('licenseTemplate.name')
                                            ->label('License'),
                                        Infolists\Components\TextEntry::make('score'),
                                    ]),
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'view' => Pages\ViewQuestion::route('/{record}'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
