<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Filament\Resources\ItemResource;
use App\Models\Stock;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageItems extends ManageRecords
{
    protected static ?string $title = 'Barang';

    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-o-plus')->createAnother(false)->using(function (array $data, string $model): Model {
                $created = $model::create($data);
                Stock::create([
                    'item_id' => $created->id,
                    'project_id' => NULL,
                    'qty' => $data['stock'],
                    'type' => 'initial',
                    'date' => date('Y-m-d')
                ]);

                return $created;
            }),
        ];
    }
}
