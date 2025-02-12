<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;



class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $modelLabel = 'Cliente';
    protected static ?string $pluralModelLabel = 'Clientes';
    protected static ?string $navigationGroup = 'Gestión';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre_completo')
                ->label('Nombre Completo')
                ->required()
                ->maxLength(200),

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

            TextInput::make('direccion')
                ->label('Dirección')
                ->maxLength(200),

            DatePicker::make('fecha_nacimiento')
                ->label('Fecha de Nacimiento')
                ->required(),

            TextInput::make('documento_identidad')
                ->label('Documento de Identidad')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(20),


        
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cliente_id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nombre_completo')
                ->label('Nombre Completo')
                ->sortable()
                ->searchable(),


                TextColumn::make('correo')
                    ->label('Correo Electrónico')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('estado_membresia')
                    ->label('Estado de Membresía')
                    ->sortable(),

                TextColumn::make('limite_apuesta_diario')
                    ->label('Límite de Apuesta Diario')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado_membresia')
                    ->label('Estado de Membresía')
                    ->options([
                        'desactivado' => 'Desactivado',
                        'activado' => 'Activado',
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}