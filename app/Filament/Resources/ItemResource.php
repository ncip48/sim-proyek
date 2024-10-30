<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $activeNavigationIcon = 'heroicon-s-circle-stack';

    protected static ?string $navigationLabel = 'Barang';

    protected static ?string $navigationGroup = 'Gudang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->rules('required')
                    ->autocomplete('off')
                    ->columnSpan('full')
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit')
                    ->rules('required')
                    ->autocomplete('off')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->rules('required')
                    ->numeric()
                    ->autocomplete('off')
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('stock')
                    ->rules('required')
                    ->numeric()
                    ->autocomplete('off')
                    ->columnSpanFull()
                    ->visible(fn(string $context): bool => $context === 'create')
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')->color('info'),
                Tables\Columns\TextColumn::make('stock')
                    ->getStateUsing(function (Model $record) {
                        $initial = Stock::where('item_id', $record->id)->where('type', 'initial')->first();
                        $in = Stock::where('item_id', $record->id)->where('type', 'in')->first();
                        $out = Stock::where('item_id', $record->id)->where('type', 'out')->first();

                        $initialStock = $initial ? $initial->qty : 0;
                        $inStock = $in ? $in->qty : 0;
                        $outStock = $out ? $out->qty : 0;
                        $totalStock = $initialStock + $inStock - $outStock;
                        return $totalStock;
                    })

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
        // ->bulkActions([
        //     Tables\Actions\BulkActionGroup::make([
        //         Tables\Actions\DeleteBulkAction::make(),
        //     ]),
        // ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageItems::route('/'),
        ];
    }
}
