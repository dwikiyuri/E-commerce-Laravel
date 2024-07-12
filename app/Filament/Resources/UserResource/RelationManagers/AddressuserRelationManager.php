<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\province;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\subprovince;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AddressuserRelationManager extends RelationManager
{
    protected static string $relationship = 'addressuser';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                ->required()
                ->maxLength(255),

                TextInput::make('last_name')
                ->required()
                ->maxLength(255),

                TextInput::make('phone')
                ->tel()
                ->required()
                ->maxLength(255),

                Select::make('province')
                ->label('Province')
                ->options(function () {
                    // Ambil data provinsi dari database
                    return province::pluck('province_name', 'province_name')->toArray();
                })
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('city', null);
                    $set('village', null);
                    $set('village_district', null);
                    $set('zip_code', null);
                })
                ->required(),

                Select::make('city')
                ->label('City')
                ->options(function (callable $get) {
                    $provinceName = $get('province');

                    if ($provinceName) {
                        // Ambil province_code dari tabel provinces berdasarkan province_name
                        $provinceCode = province::where('province_name', $provinceName)->value('province_code');

                        // Ambil data subprovince berdasarkan province_code yang dipilih
                        return Subprovince::where('province_code', $provinceCode)
                            ->orderBy('city', 'asc')
                            ->pluck('city', 'city') // Adjust this if needed
                            ->toArray();
                    }

                    return [];
                })
                ->reactive()
                ->required()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('village', null);
                    $set('village_district', null);
                    $set('zip_code', null);
                })
                ->reactive()
                ->required()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('village', null);
                    $set('village_district', null);
                    $set('zip_code', null);
                }),

                Select::make('village')
                ->options(function (callable $get) {
                    $city = $get('city');
                    if ($city) {
                        return subprovince::where('city', $city)
                            ->orderBy('sub_district', 'asc')
                            ->pluck('sub_district', 'sub_district')
                            ->toArray();
                    }

                    return [];
                })
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('village_district', null);
                    $set('zip_code', null);
                })
                ->required(),

                Select::make('village_district')
                ->label('Village District')
                ->options(function (callable $get) {
                 $village = $get('village');

                if ($village) {
                     return subprovince::where('sub_district', $village)
                    ->orderBy('urban', 'asc')
                    ->pluck('urban', 'urban')
                    ->toArray();
                }
                return [];
                })
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                 $set('zip_code', null);
                 })
                ->required(),

                Select::make('zip_code')
                ->required()
                ->label('Zip Code')
                ->options(function (callable $get) {
                    $villageDistrict = $get('village_district');

                    if ($villageDistrict) {
                        return subprovince::where('urban', $villageDistrict)
                            ->pluck('postal_code', 'postal_code')
                            ->toArray();
                    }

                    return [];
                }),

                Textarea::make('street_address')
                ->required()
                ->columnSpanFull(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('street_address')
            ->columns([
                TextColumn::make('fullname')
                ->label('Full Name'),
                TextColumn::make('phone'),
                TextColumn::make('province'),
                TextColumn::make('city'),
                TextColumn::make('zip_code'),
                TextColumn::make('street_address')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
