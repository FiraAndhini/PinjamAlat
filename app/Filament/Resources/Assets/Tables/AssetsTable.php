<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->size(50)
                    ->label('Picture'),

                TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->label('Asset Code'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Asset Name'),

                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->label('Category'),

                TextColumn::make('available_quantity')
                    ->numeric()
                    ->sortable()
                    ->label('Available'),

                TextColumn::make('total_quantity')
                    ->numeric()
                    ->sortable()
                    ->label('Total'),

                TextColumn::make('good')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('damage')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('borrowed')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('lost')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category'),

                TernaryFilter::make('is_available')
                    ->label('Available Status'),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}