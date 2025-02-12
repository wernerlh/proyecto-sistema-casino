<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserClienteResource\Pages;
use App\Filament\Resources\UserClienteResource\RelationManagers;
use App\Models\User;
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


class UserClienteResource extends Resource
{
    protected static ?string $model = User::class;

    
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Usuarios de Clientes';
    protected static ?string $modelLabel = 'Usuario Cliente';
    protected static ?string $pluralModelLabel = 'Usuarios de Clientes';
    protected static ?string $navigationGroup = 'Seguridad';
    // Aquí defines el orden
    public static function getNavigationSort(): ?int
    {
        return 2; // Irá primero
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('cliente_id')
                ->label('Seleccione un Cliente')
                ->relationship('cliente', 'nombre_completo') // Relación con el modelo Cliente
                ->searchable()
                ->preload()
                ->live() // Hace que el campo sea reactivo
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    // Obtiene el DNI del cliente seleccionado
                    $cliente = Cliente::find($state);
                    if ($cliente) {
                    // Genera el valor para el campo 'name'
                    $nombreCompleto = $cliente->nombre_completo; // Nombre completo (nombre + apellido)
                    $nombreSinEspacios = str_replace(' ', '', $nombreCompleto); // Elimina espacios del nombre completo
                    $anioNacimiento = date('Y', strtotime($cliente->fecha_nacimiento)); // Obtiene el año de nacimiento
                    $name = strtolower($nombreSinEspacios . $anioNacimiento); // Concatena y convierte a minúsculas

                    $set('name', $name); // Actualiza el campo name

                    $set('dni_cliente', $cliente->documento_identidad); // Actualiza el campo DNI
                    $set('email', $cliente->correo); // Actualiza el campo email
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

            // Campo para mostrar el DNI del cliente (deshabilitado)
            TextInput::make('dni_cliente')
            ->label('DNI del Cliente')
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
            ->default(['user']) // Valor por defecto
            ->disabled() // Deshabilitado



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('cliente', function ($q) {
                    $q->whereNotNull('nombre_completo')->where('nombre_completo', '!=', '');
                });
            })
            ->columns([
                TextColumn::make('row_number')
                ->label('N°')
                ->rowIndex()
                ->sortable(),
    
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
            'index' => Pages\ListUserClientes::route('/'),
            'create' => Pages\CreateUserCliente::route('/create'),
            'edit' => Pages\EditUserCliente::route('/{record}/edit'),
        ];
    }
}
