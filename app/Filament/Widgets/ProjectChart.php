<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Proyek;

class ProjectChart extends ChartWidget
{
    protected static ?string $heading = 'Status Proyek';

    protected static ?string $pollingInterval = '5s';

    protected static ?string $maxHeight = '300px';

    protected static ?array $options = [
        'plugins' => [
            //remove the x and y axis
            'legend' => [
                'display' => false,
            ],
        ],
        'scales' => [
            'x' => [
                'ticks' => [
                    'display' => false,
                ],
                'grid' => [
                    'drawBorder' => false,
                    'display' => false,
                ],
            ],
            'y' => [
                'ticks' => [
                    'display' => false,
                    'beginAtZero' => true,
                ],
                'grid' => [
                    'drawBorder' => false,
                    'display' => false,
                ],
            ],
        ],
    ];

    public function getDescription(): ?string
    {
        return 'Jumlah proyek berdasarkan status';
    }

    protected function getData(): array
    {
        $ongoing = Proyek::where('is_done', '0')->count();
        $complete = Proyek::where('is_done', '1')->count();


        return [
            'datasets' => [
                [
                    'data' => [$ongoing, $complete],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                    ],
                    'borderColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 205, 86)',
                    ],
                ],
            ],
            'labels' => ['Ongoing', 'Complete'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
