<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardingHouseResource\Pages;
use App\Filament\Resources\BoardingHouseResource\RelationManagers;
use App\Models\BoardingHouse;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'Boarding House Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        // TAB 1: INFORMASI UMUM
                        Forms\Components\Tabs\Tab::make('Informasi Umum')
                            ->schema([
                                Forms\Components\FileUpload::make('thumbnail')
                                    ->image()
                                    ->directory('boarding-houses')
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Kost')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ->required(),

                                Forms\Components\TextInput::make('slug')
                                    ->readOnly()
                                    ->required(),

                                Forms\Components\Select::make('city_id')
                                    ->relationship('city', 'name')
                                    ->label('Kota')
                                    ->required(),

                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->label('Kategori')
                                    ->required(),

                                Forms\Components\RichEditor::make('description')
                                    ->label('Deskripsi')
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('price')
                                    ->label('Harga per Bulan')
                                    ->numeric()
                                    ->prefix('IDR')
                                    ->required(),

                                Forms\Components\Textarea::make('address')
                                    ->label('Alamat Lengkap')
                                    ->required()
                                    ->columnSpanFull(),
                            ])->columns(2),

                        // TAB 2: FASILITAS (BONUS)
                        Forms\Components\Tabs\Tab::make('Fasilitas')
                            ->schema([
                                Forms\Components\Repeater::make('bonuses')
                                    ->relationship('bonuses')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->image()
                                            ->directory('bonuses')
                                            ->required(),

                                        Forms\Components\TextInput::make('name')
                                            ->label('Nama Fasilitas')
                                            ->required(),

                                        Forms\Components\TextInput::make('description')
                                            ->label('Keterangan')
                                            ->required(),
                                    ])
                                    ->grid(2), // Tampilan grid agar rapi
                            ]),

                        // TAB 3: KAMAR
                        Forms\Components\Tabs\Tab::make('Kamar')
                            ->schema([
                                Forms\Components\Repeater::make('rooms')
                                    ->relationship('rooms')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nama Kamar')
                                            ->required(),

                                        Forms\Components\TextInput::make('room_type')
                                            ->label('Tipe Kamar')
                                            ->required(),

                                        Forms\Components\TextInput::make('square_feet')
                                            ->label('Ukuran (m²)')
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('capacity')
                                            ->label('Kapasitas Orang')
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('price_per_month')
                                            ->label('Harga/Bulan')
                                            ->numeric()
                                            ->prefix('IDR')
                                            ->required(),

                                        Forms\Components\Toggle::make('is_available')
                                            ->label('Tersedia')
                                            ->default(true)
                                            ->required(),

                                        Forms\Components\Repeater::make('images')
                                            ->relationship('images')
                                            ->schema([
                                                Forms\Components\FileUpload::make('image')
                                                    ->image()
                                                    ->directory('rooms')
                                                    ->required(),
                                            ])
                                            ->grid(3)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // PERBAIKAN DI SINI: Gunakan ImageColumn, hapus TextColumn thumbnail
                ImageColumn::make('thumbnail')
                    ->circular() // Gambar bulat
                    ->label('Foto'),

                TextColumn::make('name')
                    ->label('Nama Kost')
                    ->searchable(),

                TextColumn::make('city.name')
                    ->label('Kota')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListBoardingHouses::route('/'),
            'create' => Pages\CreateBoardingHouse::route('/create'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}