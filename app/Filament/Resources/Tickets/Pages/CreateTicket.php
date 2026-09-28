<?php

namespace App\Filament\Resources\Tickets\Pages;

use App\Filament\Resources\Tickets\TicketResource; // <-- Jangan di-komen / aktifkan ini
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class; // <-- Tambahkan baris wajib ini!

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['ticket_number'] = 'REQ-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        return $data;
    }
}