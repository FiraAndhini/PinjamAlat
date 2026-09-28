<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsSection::make('Borrowing Information')
                    ->description('Kelola data peminjaman alat')
                    ->schema([
                        ComponentsGrid::make(3)->schema([
                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->label('Requester')
                                ->required(),

                            Select::make('asset_id')
                                ->relationship('asset', 'name')
                                ->label('Asset Name')
                                ->required(),

                            DatePicker::make('return_date')
                                ->label('Return Date')
                                ->required(),
                        ]),

                        Textarea::make('note')
                            ->label('Additional Note')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
