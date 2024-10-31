<?php

namespace App\Filament\Resources\TrackingBarangResource\Pages;

use App\Filament\Resources\TrackingBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTrackingBarangs extends ManageRecords
{
    protected static ?string $title = 'Tracking Barang';

    protected static string $resource = TrackingBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
