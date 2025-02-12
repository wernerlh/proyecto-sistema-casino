<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsistenciaEmpleadoResource\Pages;
use App\Filament\Resources\AsistenciaEmpleadoResource\RelationManagers;
use App\Models\AsistenciaEmpleado;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsistenciaEmpleadoResource extends Resource
{
    protected static ?string $model = AsistenciaEmpleado::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock'; // Icono para el menú de navegación
    protected static ?string $navigationLabel = 'Asistencias'; // Etiqueta del menú
    protected static ?string $modelLabel = 'Asistencia'; // Etiqueta singular
    protected static ?string $pluralModelLabel = 'Asistencias'; // Etiqueta plural
    protected static ?string $navigationGroup = 'Gestión de Personal'; // Grupo de navegación

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('empleado_id')
                    ->label('Empleado')
                    ->relationship('empleado', 'nombre') // Relación con el modelo Empleado
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('fecha')
                    ->label('Fecha')
                    ->required()
                    ->default(now()),

                TimePicker::make('hora_entrada')
                    ->label('Hora de Entrada')
                    ->required(),

                TimePicker::make('hora_salida')
                    ->label('Hora de Salida')
                    ->nullable(),

                TextInput::make('horas_trabajadas')
                    ->label('Horas Trabajadas')
                    ->numeric()
                    ->step(0.01)
                    ->nullable(),

                Select::make('tipo_jornada')
                    ->label('Tipo de Jornada')
                    ->options([
                        'COMPLETA' => 'Completa',
                        'MEDIA' => 'Media',
                        'EXTRA' => 'Extra',
                    ])
                    ->required(),

                Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'PRESENTE' => 'Presente',
                        'AUSENTE' => 'Ausente',
                        'TARDANZA' => 'Tardanza',
                        'PERMISO' => 'Permiso',
                    ])
                    ->required(),

                TextInput::make('observaciones')
                    ->label('Observaciones')
                    ->nullable()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asistencia_id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('empleado.nombre')
                    ->label('Empleado')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),

                TextColumn::make('hora_entrada')
                    ->label('Hora de Entrada')
                    ->time(),

                TextColumn::make('hora_salida')
                    ->label('Hora de Salida')
                    ->time(),

                TextColumn::make('horas_trabajadas')
                    ->label('Horas Trabajadas')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),

                TextColumn::make('tipo_jornada')
                    ->label('Tipo de Jornada')
                    ->sortable(),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->sortable(),

                TextColumn::make('observaciones')
                    ->label('Observaciones')
                    ->limit(50), // Limita la longitud del texto
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('empleado_id')
                    ->label('Empleado')
                    ->relationship('empleado', 'nombre')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('tipo_jornada')
                    ->label('Tipo de Jornada')
                    ->options([
                        'COMPLETA' => 'Completa',
                        'MEDIA' => 'Media',
                        'EXTRA' => 'Extra',
                    ]),

                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'PRESENTE' => 'Presente',
                        'AUSENTE' => 'Ausente',
                        'TARDANZA' => 'Tardanza',
                        'PERMISO' => 'Permiso',
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
            'index' => Pages\ListAsistenciaEmpleados::route('/'),
            'create' => Pages\CreateAsistenciaEmpleado::route('/create'),
            'edit' => Pages\EditAsistenciaEmpleado::route('/{record}/edit'),
        ];
    }
}
