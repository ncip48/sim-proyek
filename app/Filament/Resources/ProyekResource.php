<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProyekResource\Pages;
use App\Filament\Resources\ProyekResource\RelationManagers;
use App\Models\Proyek;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProyekResource extends Resource
{
    protected static ?string $model = Proyek::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Proyek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->autocomplete('off')
                    ->rules('required'),
                Forms\Components\TextInput::make('location')->autocomplete('off')
                    ->rules('required'),
                Forms\Components\DatePicker::make('start_date')
                    ->rules('required'),
                Forms\Components\DatePicker::make('end_date')
                    ->rules('required'),
                Forms\Components\TextInput::make('budget')->autocomplete('off')
                    ->rules('required')->numeric(),
                Forms\Components\Radio::make('is_done')->label('Status')
                    ->options([
                        '0' => 'On Progress',
                        '1' => 'Done',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('location')->searchable(),
                Tables\Columns\TextColumn::make('start_date')->searchable(),
                Tables\Columns\TextColumn::make('end_date')->searchable(),
                Tables\Columns\TextColumn::make('budget')->searchable()->numeric(),
                Tables\Columns\IconColumn::make('is_done')
                    ->color(fn(string $state): string => match ($state) {
                        $state => !empty($state) ? 'success' : 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        $state => !empty($state) ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle',
                    })
                    ->label('Finish'),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\ForceDeleteAction::make(),
                // Tables\Actions\RestoreAction::make(),
            ])
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProyeks::route('/'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->withoutGlobalScopes([
    //             SoftDeletingScope::class,
    //         ]);
    // }
}
