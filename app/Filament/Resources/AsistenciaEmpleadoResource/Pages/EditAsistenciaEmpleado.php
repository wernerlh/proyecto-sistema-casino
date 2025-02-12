<?php

namespace App\Filament\Resources\AsistenciaEmpleadoResource\Pages;

use App\Filament\Resources\AsistenciaEmpleadoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsistenciaEmpleado extends EditRecord
{
    protected static string $resource = AsistenciaEmpleadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
