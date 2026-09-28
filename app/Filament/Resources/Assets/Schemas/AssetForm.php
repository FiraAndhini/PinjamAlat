<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use App\Models\Category;
use App\Models\Asset;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Illuminate\Support\Str;

class AssetForm
{
    // Fungsi untuk menghitung total quantity dan available secara otomatis
    protected static function recalculate($get, $set)
    {
        $good = (int) $get('good');
        $damage = (int) $get('damage');
        $borrowed = (int) $get('borrowed');
        $lost = (int) $get('lost');

        // Hitung total keseluruhan kondisi barang
        $set('total_quantity', $good + $damage + $borrowed + $lost);

        // Hitung stok yang tersedia untuk dipinjam (Barang bagus dikurangi yang sedang dipinjam)
        $set('available_quantity', max(0, $good - $borrowed));
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsGrid::make(3)
                    ->schema([
                        ComponentsSection::make('Asset Details')
                            ->schema([
                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->label('Category')
                                    ->reactive()
                                    ->afterStateUpdated(function ($get, $set) {
                                        // Auto generate kode aset berdasarkan 3 huruf kategori + nomor urut
                                        $categoryId = $get('category_id');
                                        if (!$categoryId) {
                                            return;
                                        }

                                        $category = Category::find($categoryId);
                                        if (!$category) {
                                            return;
                                        }

                                        $prefix = strtoupper(Str::substr($category->name, 0, 3));
                                        
                                        $lastCode = Asset::where('code', 'like', $prefix . '%')
                                            ->orderBy('code', 'desc')
                                            ->value('code');

                                        if ($lastCode) {
                                            $number = (int) Str::substr($lastCode, -3);
                                            $nextNumber = $number + 1;
                                        } else {
                                            $nextNumber = 1;
                                        }

                                        $code = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                                        $set('code', $code);
                                    }),

                                TextInput::make('code')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->readOnly(),

                                TextInput::make('name')
                                    ->required()
                                    ->columnSpanFull(),

                                RichEditor::make('description')
                                    ->label('Description')
                                    ->columnSpanFull()
                                    ->extraAttributes(['style' => 'min-height: 250px;']),

                                FileUpload::make('image')
                                    ->label('Asset Picture')
                                    ->disk('public')
                                    ->directory('asset-pictures')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(2),

                        Section::make('Status')
                            ->schema([
                                Toggle::make('is_available')
                                    ->default(true)
                                    ->required(),
                            ])
                            ->columnSpan(1),
                    ]),

                Section::make('Asset Condition')
                    ->schema([
                        TextInput::make('available_quantity')
                            ->numeric()
                            ->default(0)
                            ->readOnly()
                            ->label('Available')
                            ->helperText('Available asset for borrowing'),

                        TextInput::make('total_quantity')
                            ->numeric()
                            ->default(0)
                            ->readOnly(),

                        TextInput::make('good')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($get, $set) => self::recalculate($get, $set)),

                        TextInput::make('damage')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($get, $set) => self::recalculate($get, $set)),

                        TextInput::make('borrowed')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($get, $set) => self::recalculate($get, $set)),

                        TextInput::make('lost')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($get, $set) => self::recalculate($get, $set)),
                    ])
                    ->columns(5),
            ]);
    }
}