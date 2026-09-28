<?php

namespace App\Filament\Resources\AssetReturns\Pages;

use App\Filament\Resources\AssetReturns\AssetReturnResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Components\Section as ComponentsSection;

class ViewAssetReturn extends ViewRecord
{
    protected static string $resource = AssetReturnResource::class;
    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section 1: Informasi Tiket
                ComponentsSection::make('Ticket Info')
                    ->description('Informasi peminjaman dan verifikasi tiket')
                    ->schema([
                        ComponentsGrid::make(3)->schema([
                            TextEntry::make('ticket.id')
                                ->label('Ticket Number'),
                            TextEntry::make('ticket.status')
                                ->label('Status Verifikasi')
                                ->badge()
                                ->color('success'),
                            TextEntry::make('return_date')
                                ->label('Tanggal Pengembalian')
                                ->dateTime(),
                        ]),
                    ]),

                // Section 2: Detail Aset & Kondisi
                ComponentsSection::make('Asset Detail')
                    ->description('Kondisi fisik aset saat dikembalikan')
                    ->schema([
                        ComponentsGrid::make(3)->schema([
                            TextEntry::make('ticket.asset.name')
                                ->label('Asset Name'),
                            TextEntry::make('quantity')
                                ->label('Quantity'),
                            TextEntry::make('condition')
                                ->label('Kondisi')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'good' => 'success',
                                    'damaged' => 'warning',
                                    'lost' => 'danger',
                                    default => 'gray',
                                }),
                        ]),
                        TextEntry::make('notes')
                            ->label('Catatan Pengembalian')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}