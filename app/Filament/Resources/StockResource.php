<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Filament\Resources\StockResource\RelationManagers;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $activeNavigationIcon = 'heroicon-s-cube';

    protected static ?string $navigationLabel = 'Stok';

    protected static ?string $navigationGroup = 'Gudang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('project_id')
                    ->numeric(),
                Forms\Components\TextInput::make('qty')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
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
                Tables\Columns\TextColumn::make('item.name')
                    ->getStateUsing(function (Model $record) {
                        return $record->item->name;
                    })->searchable(),
                Tables\Columns\TextColumn::make('project.name')
                    ->getStateUsing(function (Model $record) {
                        return $record->project_id ? $record->project->name : "-";
                    })
                    ->label('Proyek')->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->getStateUsing(function (Model $record) {
                        return $record->qty;
                    })
                    ->numeric(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'in' => 'success',
                        'out' => 'danger',
                        'initial' => 'info',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'in' => 'Stok Masuk',
                        'out' => 'Stok Keluar',
                        'initial' => 'Stok Awal'
                    })
                    ->label('Type'),
                Tables\Columns\TextColumn::make('date')
                    ->date('d F Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn(Model $record) => in_array($record->type, ['in', 'out'])),
            ])
            ->poll('10s')
            ->defaultSort('id', 'desc');
        // ->bulkActions([
        //     Tables\Actions\BulkActionGroup::make([
        //         Tables\Actions\DeleteBulkAction::make(),
        //     ]),
        // ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStocks::route('/'),
        ];
    }
}
