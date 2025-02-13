<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios';
    protected static ?string $navigationGroup = 'Seguridad';
    // Aquí defines el orden
    public static function getNavigationSort(): ?int
    {
        return 0; // Irá primero
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->searchable(),

            TextColumn::make('empleado.nombre_completo')
                ->label('Empleado')
                ->sortable()
                ->searchable(),

            TextColumn::make('cliente.nombre_completo')
                ->label('Cliente')
                ->sortable()
                ->searchable(),

            TextColumn::make('name')
                ->label('Nombre')
                ->sortable()
                ->searchable(),
            

            TextColumn::make('email')
                ->label('Correo Electrónico')
                ->sortable()
                ->searchable(),


            TextColumn::make('created_at')
                ->label('Creado')
                ->sortable()
                ->searchable(),
            TextColumn::make('updated_at')
                ->label('Actualizado')
                ->sortable()
                ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            // No incluyas 'create' ni 'edit'
        ];
    }
}
