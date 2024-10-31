<?php

namespace App\Filament\Resources\StockResource\Pages;

use App\Filament\Resources\StockResource;
use App\Models\Item;
use App\Models\Stock;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRecords;

class ManageStocks extends ManageRecords
{
    protected static ?string $title = 'Stok';

    protected static string $resource = StockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Stock In')->label('Stock In')
                ->form([
                    Select::make('item_id')
                        ->label('Item')
                        ->options(Item::query()->pluck('name', 'id'))
                        ->rules('required')
                        ->searchable(),
                    TextInput::make('qty')
                        ->label('Qty')
                        ->rules('required')
                        ->numeric()
                        ->autocomplete('off')
                        ->columnSpanFull()
                ])
                ->action(function (array $data): void {
                    Stock::create([
                        'item_id' => $data['item_id'],
                        'qty' => $data['qty'],
                        'type' => 'in',
                        'date' => date('Y-m-d')
                    ]);
                }),
            Actions\CreateAction::make()->createAnother(false)->label('Stock Out')->color('danger'),
        ];
    }
}
