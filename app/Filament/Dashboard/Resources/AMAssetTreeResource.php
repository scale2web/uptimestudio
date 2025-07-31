<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AMAssetTreeResource\Pages;
use App\Models\AMAsset;
use App\Models\AmAssetType;
use App\Models\AmAssetLifecycleState;
use App\Models\AmFunctionalLocation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AMAssetTreeResource extends Resource
{
    protected static ?string $model = AMAsset::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('Assets');
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function getNavigationLabel(): string
    {
        return __('Asset Tree');
    }

    public static function getModelLabel(): string
    {
        return __('Asset Tree');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Asset Trees');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('maintenance_asset')
                            ->label(__('Asset ID'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText(__('Unique identifier for this asset')),

                        Forms\Components\TextInput::make('name')
                            ->label(__('Asset Name'))
                            ->required()
                            ->maxLength(255)
                            ->helperText(__('Descriptive name for this asset')),

                        Forms\Components\Select::make('am_asset_type_id')
                            ->label(__('Asset Type'))
                            ->required()
                            ->relationship('assetType', 'maintenance_asset_type')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->maintenance_asset_type} - {$record->name}")
                            ->searchable()
                            ->preload()
                            ->helperText(__('Select the type of this asset')),

                        Forms\Components\Select::make('am_asset_lifecycle_state_id')
                            ->label(__('Lifecycle State'))
                            ->relationship('lifecycleState', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText(__('Current state of this asset in its lifecycle')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Hierarchy'))
                    ->schema([
                        Forms\Components\Select::make('parent_maintenance_asset_id')
                            ->label(__('Parent Asset'))
                            ->relationship('parent', 'maintenance_asset')
                            ->searchable()
                            ->preload()
                            ->helperText(__('Parent asset if this is a sub-component'))
                            ->placeholder(__('Select parent asset (leave empty for root assets)')),

                        Forms\Components\Select::make('am_functional_location_id')
                            ->label(__('Functional Location'))
                            ->relationship('functionalLocation', 'functional_location')
                            ->searchable()
                            ->preload()
                            ->helperText(__('Where this asset is installed')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Additional Information'))
                    ->schema([
                        Forms\Components\TextInput::make('serial_id')
                            ->label(__('Serial Number'))
                            ->maxLength(255)
                            ->helperText(__('Serial number of this asset')),

                        Forms\Components\TextInput::make('model_id')
                            ->label(__('Model ID'))
                            ->maxLength(255)
                            ->helperText(__('Model identifier for this asset')),

                        Forms\Components\TextInput::make('acquisition_cost')
                            ->label(__('Acquisition Cost'))
                            ->numeric()
                            ->prefix('$')
                            ->helperText(__('Original purchase cost of this asset')),

                        Forms\Components\Textarea::make('notes')
                            ->label(__('Notes'))
                            ->rows(3)
                            ->helperText(__('Additional notes about this asset')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('maintenance_asset')
                    ->label(__('Asset ID'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->description(fn (AMAsset $record): string => $record->name)
                    ->icon('heroicon-o-cog-6-tooth'),

                Tables\Columns\TextColumn::make('assetType.maintenance_asset_type')
                    ->label(__('Asset Type'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('lifecycleState.name')
                    ->label(__('Lifecycle State'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('secondary'),

                Tables\Columns\TextColumn::make('functionalLocation.functional_location')
                    ->label(__('Functional Location'))
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->placeholder(__('Not assigned')),

                Tables\Columns\TextColumn::make('serial_id')
                    ->label(__('Serial Number'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('model_id')
                    ->label(__('Model ID'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('acquisition_cost')
                    ->label(__('Acquisition Cost'))
                    ->money('USD')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('children_count')
                    ->label(__('Child Assets'))
                    ->counts('children')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('am_asset_type_id')
                    ->label(__('Asset Type'))
                    ->options(function () {
                        return AmAssetType::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                            ->pluck('maintenance_asset_type', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\SelectFilter::make('am_asset_lifecycle_state_id')
                    ->label(__('Lifecycle State'))
                    ->options(function () {
                        return AmAssetLifecycleState::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\SelectFilter::make('am_functional_location_id')
                    ->label(__('Functional Location'))
                    ->options(function () {
                        return AmFunctionalLocation::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                            ->pluck('functional_location', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('has_parent')
                    ->label(__('Has Parent Asset'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('parent_maintenance_asset_id'),
                        false: fn (Builder $query) => $query->whereNull('parent_maintenance_asset_id'),
                    ),

                Tables\Filters\TernaryFilter::make('has_children')
                    ->label(__('Has Child Assets'))
                    ->queries(
                        true: fn (Builder $query) => $query->has('children'),
                        false: fn (Builder $query) => $query->doesntHave('children'),
                    ),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('Is Active'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereNull('active_to'),
                        false: fn (Builder $query) => $query->whereNotNull('active_to'),
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('maintenance_asset', 'asc')
            ->searchable()
            ->filtersLayout(FiltersLayout::AboveContent)
            ->emptyStateHeading(__('No Assets Found'))
            ->emptyStateDescription(__('Create your first asset to start building your asset hierarchy.'))
            ->emptyStateIcon('heroicon-o-rectangle-stack')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->contentGrid([
                'default' => 'full',
                'sm' => 'full',
                'md' => 'full',
                'lg' => 'full',
                'xl' => 'full',
                '2xl' => 'full',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAMAssetTrees::route('/'),
            'tree-view' => Pages\TreeViewAMAssetTree::route('/tree-view'),
            'assembly-view' => Pages\AssemblyViewAMAssetTree::route('/assembly-view'),
            'create' => Pages\CreateAMAssetTree::route('/create'),
            'edit' => Pages\EditAMAssetTree::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
            ->with(['children', 'parent', 'assetType', 'lifecycleState', 'functionalLocation']);
    }
} 