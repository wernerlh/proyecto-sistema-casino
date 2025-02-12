<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Empleado;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('empleado_id')
                ->label('Seleccione un Empleado')
                ->relationship('empleado', 'nombre') // Relación con el modelo Empleado
                ->searchable()
                ->preload()
                ->live() // Hace que el campo sea reactivo
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    // Obtiene el DNI del empleado seleccionado
                    $empleado = Empleado::find($state);
                    if ($empleado) {
                    // Genera el valor para el campo 'name'
                    $nombreCompleto = $empleado->nombre . $empleado->apellido; // Nombre completo (nombre + apellido)
                    $nombreSinEspacios = str_replace(' ', '', $nombreCompleto); // Elimina espacios del nombre completo
                    $anioNacimiento = date('Y', strtotime($empleado->fecha_nacimiento)); // Obtiene el año de nacimiento
                    $name = strtolower($nombreSinEspacios . $anioNacimiento); // Concatena y convierte a minúsculas

                    $set('name', $name); // Actualiza el campo name

                    $set('dni_empleado', $empleado->documento_identidad); // Actualiza el campo DNI
                    $set('email', $empleado->correo); // Actualiza el campo email
                    }
                }),
                //->required(),

            TextInput::make('name')
                ->label('Usuario')
                ->required()
                ->maxLength(100),

            TextInput::make('email')
                ->label('Correo Electrónico')
                ->email()
                ->required()
                ->maxLength(100),

            // Campo para mostrar el DNI del empleado (deshabilitado)
            TextInput::make('dni_empleado')
            ->label('DNI del Empleado')
            ->disabled() // Deshabilita el campo
            ->dehydrated(false), // No guarda este campo en la base de datos

            TextInput::make('password')
            ->label('Contraseña')
            ->password()
            ->required()
            ->dehydrateStateUsing(fn ($state) => Hash::make($state)), // Encripta la contraseña

            // Using Select Component
            Forms\Components\Select::make('roles')
            ->relationship('roles', 'name')
            ->multiple()
            ->preload()
            ->searchable()


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->searchable(),

            TextColumn::make('empleado.nombre')
                ->label('Empleado')
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
                Tables\Actions\EditAction::make(),
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
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
