<?php

namespace App\Filament\Resources\UserSistemResource\Pages;

use App\Filament\Resources\UserSistemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserSistem extends EditRecord
{
    protected static string $resource = UserSistemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
