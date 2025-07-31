<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewAmFunctionalLocation extends ViewRecord
{
    protected static string $resource = AmFunctionalLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Basic Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('functional_location')
                            ->label('Functional Location ID'),
                        Infolists\Components\TextEntry::make('name')
                            ->label('Name'),
                        Infolists\Components\TextEntry::make('parentLocation.name')
                            ->label('Parent Location')
                            ->placeholder('Root Level'),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Type & Lifecycle')
                    ->schema([
                        Infolists\Components\TextEntry::make('functionalLocationType.name')
                            ->label('Location Type')
                            ->badge(),
                        Infolists\Components\TextEntry::make('lifecycleState.name')
                            ->label('Lifecycle State')
                            ->badge()
                            ->color('success'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Configuration')
                    ->schema([
                        Infolists\Components\TextEntry::make('default_dimension_display_value')
                            ->label('Default Dimension Display Value')
                            ->numeric(),
                        Infolists\Components\TextEntry::make('inventory_location_id')
                            ->label('Inventory Location ID'),
                        Infolists\Components\TextEntry::make('inventory_site_id')
                            ->label('Inventory Site ID'),
                        Infolists\Components\TextEntry::make('logistics_location_id')
                            ->label('Logistics Location ID'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Hierarchy Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('depth')
                            ->label('Depth Level')
                            ->formatStateUsing(fn($state) => "Level {$state}"),
                        Infolists\Components\TextEntry::make('path')
                            ->label('Full Path')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('childLocations')
                            ->label('Child Locations')
                            ->formatStateUsing(fn($record) => $record->childLocations->count() . ' child location(s)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Additional Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('notes')
                            ->label('Notes')
                            ->placeholder('No notes available')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
