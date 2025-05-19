<?php

namespace App\Filament\Cohort\Resources\BatchResource\Pages;

use App\Filament\Cohort\Resources\BatchResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ViewBatchResource extends ViewRecord
{
    protected static string $resource = BatchResource::class;

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    public function getBreadcrumb(): string
    {
        return '';
    }

    public function getTitle(): string | Htmlable
    {
        return '';
    }
}
