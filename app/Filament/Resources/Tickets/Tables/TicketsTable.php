<?php

namespace App\Filament\Resources\Tickets\Tables;

use Filament\Actions\Action as ActionsAction;
use Filament\Actions\BulkActionGroup as ActionsBulkActionGroup;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Actions\ViewAction as ActionsViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->searchable()
                    ->sortable()
                    ->label('Ticket No.'),

                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Borrower'),

                TextColumn::make('asset.name')
                    ->searchable()
                    ->sortable()
                    ->label('Asset Name'),

                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'booked' => 'Booked',
                        'borrowed' => 'Sedang Dipinjam',
                        'verifying' => 'Verifikasi',
                        'returned' => 'Dikembalikan',
                        'cancel' => 'Dibatalkan',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'booked' => 'gray',
                        'borrowed' => 'success',
                        'verifying' => 'warning',
                        'returned' => 'info',
                        'cancel' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('borrowed_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Borrowed At'),

                TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable()
                    ->label('Due Date'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionsViewAction::make(),
                ActionsEditAction::make(),

                // Tombol Reject / Cancel (Khusus status booked)
                ActionsAction::make('cancel')
                    ->label('Reject')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'booked')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'cancel',
                        ]);
                    }),

                // Tombol Approve Peminjaman (Khusus status booked)
                ActionsAction::make('approveBorrowing')
                    ->label('Approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'booked')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'borrowed',
                            'borrowed_at' => now(),
                        ]);
                    }),

                // Tombol Verifikasi Pengembalian (Khusus status borrowed)
                ActionsAction::make('purifyReturn')
                    ->label('Verify Return')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'borrowed')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'verifying',
                        ]);
                    }),

                // Tombol Complete Pengembalian (Khusus status verifying)
                ActionsAction::make('complete')
                    ->label('Complete')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'verifying')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'returned',
                            'return_add' => now(),
                        ]);
                    }),
            ])
            ->bulkActions([
                ActionsBulkActionGroup::make([
                    ActionsDeleteBulkAction::make(),
                ]),
            ]);
    }
}