<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmpleadoResource\Pages;
use App\Filament\Resources\EmpleadoResource\RelationManagers;
use App\Models\Empleado;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmpleadoResource extends Resource
{
    protected static ?string $model = Empleado::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; // Icono para el menú de navegación
    protected static ?string $navigationLabel = 'Empleados'; // Etiqueta del menú
    protected static ?string $modelLabel = 'Empleado'; // Etiqueta singular
    protected static ?string $pluralModelLabel = 'Empleados'; // Etiqueta plural
    protected static ?string $navigationGroup = 'Gestión de Personal'; // Grupo de navegación


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre')
                    ->label('Nombre y apellido')
                    ->required()
                    ->maxLength(100),


                TextInput::make('documento_identidad')
                    ->label('Documento de Identidad')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),

                TextInput::make('correo')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(100),

                TextInput::make('telefono')
                    ->label('Teléfono')
                    ->tel()
                    ->maxLength(15),

                Select::make('rol')
                    ->label('Rol')
                    ->options([
                        'ADMIN' => 'Administrador',
                        'DEALER' => 'Dealer',
                        'SOPORTE' => 'Soporte',
                        'SEGURIDAD' => 'Seguridad',
                        'CAJERO' => 'Cajero',
                    ])
                    ->required(),

                DatePicker::make('fecha_contratacion')
                    ->label('Fecha de Contratación')
                    ->required(),

                DatePicker::make('fecha_nacimiento')
                    ->label('Fecha de Nacimiento')
                    ->required(),

                Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'ACTIVO' => 'Activo',
                        'INACTIVO' => 'Inactivo',
                        'VACACIONES' => 'Vacaciones',
                        'LICENCIA' => 'Licencia',
                    ])
                    ->required(),

                TextInput::make('salario_base')
                    ->label('Salario Base')
                    ->numeric()
                    ->required(),

                Select::make('supervisor_id')
                    ->label('Supervisor')
                    ->relationship('supervisor', 'nombre') // Relación con el mismo modelo Empleado
                    ->searchable()
                    ->preload(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('empleado_id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('apellido')
                    ->label('Apellido')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('documento_identidad')
                    ->label('Documento de Identidad')
                    ->searchable(),

                TextColumn::make('correo')
                    ->label('Correo Electrónico')
                    ->searchable(),

                TextColumn::make('rol')
                    ->label('Rol')
                    ->sortable(),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->sortable(),

                TextColumn::make('salario_base')
                    ->label('Salario Base')
                    ->money('S/.') // Formato de moneda
                    ->sortable(),

                TextColumn::make('supervisor.nombre')
                    ->label('Supervisor')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rol')
                    ->options([
                        'ADMIN' => 'Administrador',
                        'DEALER' => 'Dealer',
                        'SOPORTE' => 'Soporte',
                        'SEGURIDAD' => 'Seguridad',
                        'CAJERO' => 'Cajero',
                    ]),

                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'ACTIVO' => 'Activo',
                        'INACTIVO' => 'Inactivo',
                        'VACACIONES' => 'Vacaciones',
                        'LICENCIA' => 'Licencia',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListEmpleados::route('/'),
            'create' => Pages\CreateEmpleado::route('/create'),
            'edit' => Pages\EditEmpleado::route('/{record}/edit'),
        ];
    }
}
