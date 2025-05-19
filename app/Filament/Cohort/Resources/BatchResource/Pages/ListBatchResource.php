<?php

namespace App\Filament\Cohort\Resources\BatchResource\Pages;

use App\Filament\Cohort\Resources\BatchResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Support\Htmlable;

class ListBatchResource extends ListRecords
{
    protected static string $resource = BatchResource::class;

    protected function paginateTableQuery(Builder $query): CursorPaginator
    {
        return $query->cursorPaginate(($this->getTableRecordsPerPage() === 'all') ? $query->count() : $this->getTableRecordsPerPage());
    }

    public function getBreadcrumb(): ?string
    {
        return null;
    }

    public function getTitle(): string | Htmlable
    {
        return '';
    }
}
