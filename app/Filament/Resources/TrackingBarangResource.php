<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrackingBarangResource\Pages;
use App\Models\Proyek;
use App\Models\Stock;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\View\View;

class TrackingBarangResource extends Resource
{
    protected static ?string $model = Proyek::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $activeNavigationIcon = 'heroicon-s-map-pin';

    protected static ?string $navigationLabel = 'Tracking Barang';

    protected static ?string $navigationGroup = 'Gudang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->weight('bold')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('location')->searchable()->color('success'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
                    ->label('Lihat')
                    ->modalContent(fn(Proyek $record): View => view(
                        'tracking_barang',
                        ['record' => $record, 'items' => Stock::where('project_id', $record->id)->get()],
                    )),
            ])
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTrackingBarangs::route('/'),
        ];
    }
}
