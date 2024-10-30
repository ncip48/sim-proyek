<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Proyek;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total User', User::count())
                ->icon('heroicon-o-user-group'),
            Stat::make('Total Proyek', Proyek::count())
                ->icon('heroicon-o-briefcase'),
            Stat::make('Total Material', Proyek::count())
                ->icon('heroicon-o-users'),
        ];
    }
}
