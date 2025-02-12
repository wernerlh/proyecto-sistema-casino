<?php

namespace App\Filament\Resources\UserSistemResource\Pages;

use App\Filament\Resources\UserSistemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserSistems extends ListRecords
{
    protected static string $resource = UserSistemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
