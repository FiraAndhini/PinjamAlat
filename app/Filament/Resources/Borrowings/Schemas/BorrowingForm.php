<?php

namespace App\Filament\Resources\Borrowings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class BorrowingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Siswa Peminjam'),

                Select::make('tool_id')
                    ->relationship('tool', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Alat yang Dipinjam'),

                TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->label('Jumlah'),

                DateTimePicker::make('borrowed_at')
                    ->required()
                    ->default(now())
                    ->label('Tanggal Pinjam'),

                DateTimePicker::make('returned_at')
                    ->label('Tanggal Kembali')
                    ->nullable(),

                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'borrowed' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->required()
                    ->default('pending')
                    ->label('Status Peminjaman'),
            ]);
    }
}