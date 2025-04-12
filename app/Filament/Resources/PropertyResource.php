<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('slug', str($state)->slug());
                    })
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->readOnly()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reference_id')
                    ->label('Referencia interna / ID')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('property_type_id')
                    ->label('Tipo de propiedad')
                    ->relationship('propertyType', 'name')
                    ->required(),
                Forms\Components\Select::make('operation_id')
                    ->label('Operación')
                    ->relationship('operation', 'name')
                    ->required(),
                Forms\Components\Select::make('property_status_id')
                    ->label('Estado de la propiedad')
                    ->relationship('propertyStatus', 'name'),
                Forms\Components\TextInput::make('address')
                    ->label('Dirección')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('locality')
                    ->label('Localidad')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('postal_code')
                    ->label('Código postal')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('province_id')
                    ->label('Provincia')
                    ->relationship('province', 'name')
                    ->required(),
                Forms\Components\TextInput::make('latitude')
                    ->label('Latitud')
                    ->numeric()
                    ->rule('between:-90,90') // Limita la latitud al rango válido
                    ->nullable(),
                Forms\Components\TextInput::make('longitude')
                    ->label('Longitud')
                    ->numeric()
                    ->rule('between:-180,180') // Limita la longitud al rango válido
                    ->nullable(),
                Forms\Components\Select::make('zone_id')
                    ->label('Zona')
                    ->relationship('zone', 'name'),
                Forms\Components\TextInput::make('constructed_area')
                    ->label('Superficie construida (m²)')
                    ->numeric(),
                Forms\Components\TextInput::make('usable_area')
                    ->label('Superficie útil (m²)')
                    ->numeric(),
                Forms\Components\TextInput::make('land_area')
                    ->label('Superficie del terreno / parcela (m²)')
                    ->numeric(),
                Forms\Components\TextInput::make('rooms')
                    ->label('Nº de habitaciones')
                    ->numeric(),
                Forms\Components\TextInput::make('bathrooms')
                    ->label('Nº de baños')
                    ->numeric(),
                Forms\Components\TextInput::make('floors')
                    ->label('Nº de plantas')
                    ->numeric(),
                Forms\Components\TextInput::make('construction_year')
                    ->label('Año de construcción'),
                Forms\Components\TextInput::make('housing_type')
                    ->label('Tipo de vivienda')
                    ->maxLength(255),
                Forms\Components\Toggle::make('living_room')
                    ->label('Salón / comedor')
                    ->required(),
                Forms\Components\Toggle::make('equipped_kitchen')
                    ->label('Cocina equipada')
                    ->required(),
                Forms\Components\Toggle::make('terrace')
                    ->label('Terraza / porche')
                    ->required(),
                Forms\Components\Toggle::make('garden')
                    ->label('Jardín')
                    ->required(),
                Forms\Components\Toggle::make('pool')
                    ->label('Piscina')
                    ->required(),
                Forms\Components\Toggle::make('storage_room')
                    ->label('Trastero')
                    ->required(),
                Forms\Components\Toggle::make('garage')
                    ->label('Garaje / parking')
                    ->required(),
                Forms\Components\TextInput::make('orientation')
                    ->label('Orientación')
                    ->maxLength(255),
                Forms\Components\TextInput::make('views')
                    ->label('Vistas')
                    ->maxLength(255),
                Forms\Components\Toggle::make('air_conditioning')
                    ->label('Aire acondicionado')
                    ->required(),
                Forms\Components\Toggle::make('fireplace')
                    ->label('Chimenea / estufa')
                    ->required(),
                Forms\Components\Toggle::make('heating')
                    ->label('Calefacción')
                    ->required(),
                Forms\Components\Toggle::make('drinking_water')
                    ->label('Agua potable')
                    ->required(),
                Forms\Components\Toggle::make('electricity')
                    ->label('Electricidad')
                    ->required(),
                Forms\Components\Toggle::make('internet')
                    ->label('Internet / fibra')
                    ->required(),
                Forms\Components\Toggle::make('well')
                    ->label('Pozo / agua de riego')
                    ->required(),
                Forms\Components\Toggle::make('solar_panels')
                    ->label('Paneles solares')
                    ->required(),
                Forms\Components\Toggle::make('security_system')
                    ->label('Sistema de seguridad')
                    ->required(),
                Forms\Components\Toggle::make('accessible')
                    ->label('Acceso adaptado / movilidad reducida')
                    ->required(),
                Forms\Components\TextInput::make('land_type')
                    ->label('Tipo de terreno')
                    ->maxLength(255),
                Forms\Components\TextInput::make('current_crops')
                    ->label('Cultivos actuales o posibles')
                    ->maxLength(255),
                Forms\Components\Toggle::make('own_well')
                    ->label('Pozo propio / derecho de agua')
                    ->required(),
                Forms\Components\Toggle::make('agricultural_facilities')
                    ->label('Almacenes / naves / instalaciones agrarias')
                    ->required(),
                Forms\Components\Toggle::make('fenced')
                    ->label('Vallado')
                    ->required(),
                Forms\Components\Toggle::make('road_access')
                    ->label('Acceso por carretera / pista')
                    ->required(),
                Forms\Components\TextInput::make('topography')
                    ->label('Topografía')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('€'),
                Forms\Components\TextInput::make('commission')
                    ->label('Comisión')
                    ->numeric(),
                Forms\Components\TextInput::make('community_fees')
                    ->label('Gastos de comunidad')
                    ->numeric(),
                Forms\Components\TextInput::make('ibi')
                    ->label('IBI anual')
                    ->numeric(),
                Forms\Components\TextInput::make('estimated_profitability')
                    ->label('Rentabilidad estimada')
                    ->numeric(),
                Forms\Components\RichEditor::make('short_description')
                    ->label('Descripción corta')
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('long_description')
                    ->label('Descripción larga')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('internal_notes')
                    ->label('Notas internas')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('gallery')
                    ->label('Galería de fotos')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->directory('properties/gallery')
                    ->nullable(),
                Forms\Components\FileUpload::make('video')
                    ->label('Vídeo')
                    ->directory('properties/videos')
                    ->nullable(),
                Forms\Components\TextInput::make('virtual_tour')
                    ->label('Tour virtual / 360º')
                    ->url()
                    ->nullable(),
                Forms\Components\FileUpload::make('blueprint')
                    ->label('Plano')
                    ->directory('properties/blueprints')
                    ->nullable(),
                Forms\Components\FileUpload::make('brochure')
                    ->label('Brochure PDF')
                    ->directory('properties/brochures')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reference_id')
                    ->label('Referencia interna / ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('propertyType.name')
                    ->label('Tipo de propiedad')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('operation.name')
                    ->label('Operación')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('propertyStatus.name')
                    ->label('Estado de la propiedad')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
