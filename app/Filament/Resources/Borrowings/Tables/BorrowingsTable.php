<?php

namespace App\Filament\Resources\Borrowings\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class BorrowingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->searchable()
                    ->sortable()
                    ->label('Siswa'),

                TextColumn::make('tool.name')
                    ->searchable()
                    ->sortable()
                    ->label('Alat'),

                TextColumn::make('quantity')
                    ->sortable()
                    ->label('Jumlah'),

                TextColumn::make('borrowed_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Tgl Pinjam'),

                TextColumn::make('returned_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Tgl Kembali'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'borrowed' => 'info',
                        'returned' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->label('Status'),
            ])
            ->filters([
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}