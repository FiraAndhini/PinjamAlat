<?php

namespace App\Filament\Resources\AssetReturns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssetReturnsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket.ticket_number')
                    ->searchable()
                    ->sortable()
                    ->label('Ticket No.'),

                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Returned By'),

                TextColumn::make('asset.name')
                    ->searchable()
                    ->sortable()
                    ->label('Asset'),

                TextColumn::make('condition')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'good' => 'success',
                        'damage' => 'warning',
                        'loss' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('return_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Return Time'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
