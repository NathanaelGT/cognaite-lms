<?php

namespace App\Filament\Admin\Resources\UserListResource\Pages;

use App\Filament\Admin\Resources\UserListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
