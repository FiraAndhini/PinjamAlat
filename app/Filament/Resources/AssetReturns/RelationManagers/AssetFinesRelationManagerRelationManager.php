<?php

namespace App\Filament\Resources\AssetReturns\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;


class AssetFinesRelationManager extends RelationManager
{
    protected static string $relationship = 'assetFines';
    protected static ?string $title = "Asset Fines";
    protected static ?string $recordTitleAttribute = 'type';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Select::make('tipe')
                    ->label('Jenis Denda')
                    ->options([
                        'telat' => 'Telat Return',
                        'rusak' => 'Rusak',
                        'hilang' => 'Hilang',
                    ])
                    ->required(),
                TextInput::make('amount')
                    ->label('Fine Amount')
                    ->numeric()
                    ->prefix('IDR')
                    ->required(),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tipe')
            ->columns([
                TextColumn::make('tipe')
                    ->label('Jenis Denda')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'telat' => 'warning',
                        'rusak' => 'danger',
                        'hilang' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('IDR'),
                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(30),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}