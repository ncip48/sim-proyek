<?php

namespace App\Filament\Resources\ProyekResource\Pages;

use App\Filament\Resources\ProyekResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProyeks extends ManageRecords
{
    protected static ?string $title = 'Proyek';

    protected static string $resource = ProyekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-o-plus')->createAnother(false)
        ];
    }
}
