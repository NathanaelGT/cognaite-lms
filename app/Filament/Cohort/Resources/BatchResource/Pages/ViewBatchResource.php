<?php

namespace App\Filament\Cohort\Resources\BatchResource\Pages;

use App\Filament\Cohort\Resources\BatchResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;

class ViewBatchResource extends ViewRecord
{
    protected static string $resource = BatchResource::class;

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getViewContent(): array
    {
        return [
            Infolists\Components\Infolist::make()
                ->schema($this->getResource()::infolist(new Infolists\Infolist()))
                ->record($this->getRecord())
        ];
    }
}
