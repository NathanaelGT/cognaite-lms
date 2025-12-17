<?php

namespace App\Filament\Admin\Resources\UserListResource\Pages;

use App\Filament\Admin\Resources\UserListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserList extends CreateRecord
{
    protected static string $resource = UserListResource::class;
}
