<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AmFunctionalLocationResource\Pages;
use App\Filament\Dashboard\Resources\AmFunctionalLocationResource\RelationManagers;
use App\Models\AmFunctionalLocation;
use App\Models\AmFunctionalLocationType;
use App\Models\AmFunctionalLocationLifecycleState;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;

class AmFunctionalLocationResource extends Resource
{
    protected static ?string $model = AmFunctionalLocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Functional Locations';

    protected static ?string $modelLabel = 'Functional Location';

    protected static ?string $pluralModelLabel = 'Functional Locations';

    protected static ?string $navigationGroup = 'Asset Management';

    protected static ?int $navigationSort = 30;

    // protected static bool $shouldRegisterNavigation = false; // Show in main navigation

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('functional_location')
                            ->label('Functional Location ID')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\Hidden::make('tenant_id')
                            ->default(fn() => Filament::getTenant()->id),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Hierarchy & Type')
                    ->schema([
                        Forms\Components\Select::make('am_parent_functional_location_id')
                            ->label('Parent Location')
                            ->relationship('parentLocation', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Select parent location (leave empty for root level)')
                            ->rules([
                                function () {
                                    return function (string $attribute, $value, \Closure $fail) {
                                        if ($value) {
                                            $record = request()->route('record');
                                            if ($record && $value == $record) {
                                                $fail('A location cannot be its own parent.');
                                            }
                                        }
                                    };
                                },
                            ])
                            ->columnSpan(1),
                        Forms\Components\Select::make('am_functional_location_types_id')
                            ->label('Location Type')
                            ->relationship('functionalLocationType', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),
                        Forms\Components\Select::make('am_asset_lifecycle_states_id')
                            ->label('Lifecycle State')
                            ->relationship('lifecycleState', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Configuration')
                    ->schema([
                        Forms\Components\TextInput::make('default_dimension_display_value')
                            ->label('Default Dimension Display Value')
                            ->numeric()
                            ->step(0.01)
                            ->default(1.00)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('inventory_location_id')
                            ->label('Inventory Location ID')
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('inventory_site_id')
                            ->label('Inventory Site ID')
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('logistics_location_id')
                            ->label('Logistics Location ID')
                            ->maxLength(255)
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hierarchical_name')
                    ->label('Functional Location Structure')
                    ->searchable(['functional_location', 'name'])
                    ->sortable(['functional_location'])
                    ->formatStateUsing(function (AmFunctionalLocation $record): string {
                        $depth = $record->depth;
                        $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $depth);
                        $icon = $record->childLocations->count() > 0 ? '📁' : '📄';

                        return $indent . $icon . ' ' . $record->functional_location . ' - ' . $record->name;
                    })
                    ->html()
                    ->extraAttributes(['style' => 'white-space: nowrap;']),
                Tables\Columns\TextColumn::make('parentLocation.name')
                    ->label('Parent Location')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Root Level')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('functionalLocationType.name')
                    ->label('Type')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('lifecycleState.name')
                    ->label('Lifecycle State')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('path')
                    ->label('Full Path')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->wrap(),
            ])
            ->defaultSort('functional_location')
            ->poll('30s') // Auto-refresh every 30 seconds
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('view_children')
                        ->label('View Children')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->visible(fn(AmFunctionalLocation $record): bool => $record->childLocations()->count() > 0)
                        ->url(
                            fn(AmFunctionalLocation $record): string =>
                            static::getUrl('index', ['tableFilters[parent_location][value]' => $record->id])
                        ),
                    Tables\Actions\Action::make('view_parent')
                        ->label('View Parent')
                        ->icon('heroicon-o-arrow-up')
                        ->color('warning')
                        ->visible(fn(AmFunctionalLocation $record): bool => $record->parentLocation !== null)
                        ->url(
                            fn(AmFunctionalLocation $record): string =>
                            static::getUrl('edit', ['record' => $record->parentLocation])
                        ),
                ])
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('parent_location')
                    ->label('Parent Location')
                    ->relationship('parentLocation', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('functionalLocationType')
                    ->label('Location Type')
                    ->relationship('functionalLocationType', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('root_only')
                    ->label('Root Locations Only')
                    ->query(fn(Builder $query): Builder => $query->whereNull('am_parent_functional_location_id'))
                    ->toggle(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ChildLocationsRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAmFunctionalLocations::route('/'),
            'tree' => Pages\TreeViewAmFunctionalLocations::route('/tree'),
            'create' => Pages\CreateAmFunctionalLocation::route('/create'),
            'view' => Pages\ViewAmFunctionalLocation::route('/{record}'),
            'edit' => Pages\EditAmFunctionalLocation::route('/{record}/edit'),
        ];
    }
}
