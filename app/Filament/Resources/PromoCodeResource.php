<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodeResource\Pages;
use App\Filament\Resources\PromoCodeResource\RelationManagers;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromoCodeResource extends Resource
{
    protected static ?string $model = PromoCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Marketing';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Detail Promo')
                ->schema([
                    FileUpload::make('image')
                        ->label('Banner Promo (Untuk Slider Home)')
                        ->image() // Validasi harus gambar
                        ->directory('promo-banners') // Disimpan di folder storage/app/public/promo-banners
                        ->columnSpanFull() // Lebar penuh
                        ->required(), // Wajib diisi agar Slider di User tidak kosong

                    Forms\Components\TextInput::make('code')
                        ->label('Kode Promo')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->placeholder('Contoh: MERDEKA45')
                        ->extraInputAttributes(['style' => 'text-transform:uppercase']) // Biar otomatis huruf besar
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi')
                        ->placeholder('Diskon khusus mahasiswa baru...')
                        ->columnSpanFull(),

                    Forms\Components\Select::make('type')
                        ->label('Tipe Diskon')
                        ->options([
                            'fixed' => 'Nominal (Rp)',
                            'percentage' => 'Persentase (%)',
                        ])
                        ->required()
                        ->native(false),

                    Forms\Components\TextInput::make('discount_amount')
                        ->label('Besar Diskon')
                        ->numeric()
                        ->prefix(fn ($get) => $get('type') === 'percentage' ? '%' : 'Rp')
                        ->required(),

                    Forms\Components\DateTimePicker::make('valid_from')
                        ->label('Berlaku Mulai')
                        ->required(),

                    Forms\Components\DateTimePicker::make('valid_until')
                        ->label('Berlaku Sampai')
                        ->required(),

                    Forms\Components\TextInput::make('usage_limit')
                        ->label('Batas Pemakaian')
                        ->numeric()
                        ->default(100),
                    
                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktifkan Promo?')
                        ->default(true)
                        ->onColor('success'),
                ])->columns(2),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            ImageColumn::make('image')
                ->label('Banner')
                ->square(),

            // 1. KODE PROMO (Bisa dicopy & dicari)
            TextColumn::make('code')
                ->label('Kode Promo')
                ->weight('bold')
                ->color('primary')
                ->copyable()
                ->searchable(),

            // 2. TIPE & BESAR DISKON
            TextColumn::make('discount_amount')
                ->label('Diskon')
                ->formatStateUsing(function ($state, $record) {
                    // Logika tampilan: Jika tipe 'percentage' tambah %, jika 'fixed' tambah Rp
                    return $record->type === 'percentage' 
                        ? $state . '%' 
                        : 'Rp ' . number_format($state, 0, ',', '.');
                })
                ->badge() // Tampil seperti badge/label
                ->color(fn ($record) => $record->type === 'percentage' ? 'warning' : 'success'),

            // 3. MASA BERLAKU (Valid Until)
            TextColumn::make('valid_until')
                ->label('Berlaku Sampai')
                ->dateTime('d M Y') // Format: 30 Nov 2025
                ->sortable()
                ->description(fn ($record) => $record->valid_until->isPast() ? 'Sudah Kadaluarsa' : 'Masih Berlaku')
                ->color(fn ($record) => $record->valid_until->isPast() ? 'danger' : 'gray'),

            // 4. BATAS PEMAKAIAN (Usage Limit)
            TextColumn::make('usage_limit')
                ->label('Kuota')
                ->numeric()
                ->sortable(),

            // 5. STATUS AKTIF (Toggle Langsung di Tabel)
            ToggleColumn::make('is_active')
                ->label('Aktif?'),
        ])
        ->defaultSort('created_at', 'desc') // Urutkan dari yang terbaru dibuat
        ->filters([
            // Filter: Hanya Tampilkan yang Aktif
            Tables\Filters\TernaryFilter::make('is_active')
                ->label('Status Aktif'),
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
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCode::route('/create'),
            'edit' => Pages\EditPromoCode::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
{
    // Menghitung hanya yang is_active = true
    return static::getModel()::where('is_active', true)->count();
}

// Opsional: Ubah warna badge jadi hijau biar fresh
public static function getNavigationBadgeColor(): ?string
{
    return 'success';
}
}
