<?php

namespace App\Filament\Resources\Majors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MajorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->label('Major Code'),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Major Name'),
            ]);
    }
}