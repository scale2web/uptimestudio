<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AMAssetResource\Pages;
use App\Filament\Dashboard\Resources\AMAssetResource\RelationManagers;
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

class AMAssetResource extends Resource
{
    protected static ?string $model = AMAsset::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function getNavigationGroup(): ?string
    {
        return __('Assets');
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getNavigationLabel(): string
    {
        return __('Assets');
    }

    public static function getModelLabel(): string
    {
        return __('Asset');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Assets');
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

                Forms\Components\Section::make(__('Location & Installation'))
                    ->schema([
                        Forms\Components\Select::make('am_functional_location_id')
                            ->label(__('Functional Location'))
                            ->relationship('functionalLocation', 'functional_location')
                            ->searchable()
                            ->preload()
                            ->helperText(__('Where this asset is installed')),

                        Forms\Components\Select::make('parent_maintenance_asset_id')
                            ->label(__('Parent Asset'))
                            ->relationship('parent', 'maintenance_asset')
                            ->searchable()
                            ->preload()
                            ->helperText(__('Parent asset if this is a sub-component')),

                        Forms\Components\TextInput::make('logistics_location_id')
                            ->label(__('Logistics Location'))
                            ->maxLength(255)
                            ->helperText(__('Storage or logistics location for this asset')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Financial Information'))
                    ->schema([
                        Forms\Components\TextInput::make('acquisition_cost')
                            ->label(__('Acquisition Cost'))
                            ->numeric()
                            ->prefix('$')
                            ->helperText(__('Original purchase cost of this asset')),

                        Forms\Components\TextInput::make('replacement_value')
                            ->label(__('Replacement Value'))
                            ->numeric()
                            ->prefix('$')
                            ->helperText(__('Current replacement value of this asset')),

                        Forms\Components\DatePicker::make('acquisition_date')
                            ->label(__('Acquisition Date'))
                            ->helperText(__('When this asset was acquired')),

                        Forms\Components\DatePicker::make('replacement_date')
                            ->label(__('Replacement Date'))
                            ->helperText(__('When this asset should be replaced')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Operational Details'))
                    ->schema([
                        Forms\Components\DatePicker::make('active_from')
                            ->label(__('Active From'))
                            ->helperText(__('When this asset became operational')),

                        Forms\Components\DatePicker::make('active_to')
                            ->label(__('Active To'))
                            ->helperText(__('When this asset was decommissioned')),

                        Forms\Components\TextInput::make('model_id')
                            ->label(__('Model ID'))
                            ->maxLength(255)
                            ->helperText(__('Model identifier for this asset')),

                        Forms\Components\TextInput::make('model_year')
                            ->label(__('Model Year'))
                            ->maxLength(255)
                            ->helperText(__('Year of the model')),

                        Forms\Components\TextInput::make('serial_id')
                            ->label(__('Serial Number'))
                            ->maxLength(255)
                            ->helperText(__('Serial number of this asset')),

                        Forms\Components\TextInput::make('product_id')
                            ->label(__('Product ID'))
                            ->maxLength(255)
                            ->helperText(__('Product identifier')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Warranty & Vendor'))
                    ->schema([
                        Forms\Components\TextInput::make('vend_account')
                            ->label(__('Vendor Account'))
                            ->maxLength(255)
                            ->helperText(__('Vendor account information')),

                        Forms\Components\DatePicker::make('warranty_date_from_vend')
                            ->label(__('Warranty Date'))
                            ->helperText(__('Warranty expiration date')),

                        Forms\Components\TextInput::make('warranty_id')
                            ->label(__('Warranty ID'))
                            ->maxLength(255)
                            ->helperText(__('Warranty identifier')),

                        Forms\Components\TextInput::make('purchase_order_id')
                            ->label(__('Purchase Order ID'))
                            ->maxLength(255)
                            ->helperText(__('Purchase order reference')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Additional Information'))
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label(__('Notes'))
                            ->rows(3)
                            ->helperText(__('Additional notes about this asset')),

                        Forms\Components\TextInput::make('default_dimension_display_value')
                            ->label(__('Default Dimension'))
                            ->numeric()
                            ->helperText(__('Default dimension display value')),

                        Forms\Components\TextInput::make('fixed_asset_id')
                            ->label(__('Fixed Asset ID'))
                            ->maxLength(255)
                            ->helperText(__('Fixed asset identifier')),

                        Forms\Components\TextInput::make('wrk_ctr_id')
                            ->label(__('Work Center ID'))
                            ->maxLength(255)
                            ->helperText(__('Work center identifier')),
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
                    ->copyable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Asset Name'))
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),

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

                Tables\Columns\TextColumn::make('acquisition_cost')
                    ->label(__('Acquisition Cost'))
                    ->money('USD')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('acquisition_date')
                    ->label(__('Acquisition Date'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('active_from')
                    ->label(__('Active From'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('active_to')
                    ->label(__('Active To'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                Tables\Columns\TextColumn::make('parent.maintenance_asset')
                    ->label(__('Parent Asset'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated'))
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

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('Is Active'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereNull('active_to'),
                        false: fn (Builder $query) => $query->whereNotNull('active_to'),
                    ),

                Tables\Filters\Filter::make('acquisition_date_range')
                    ->label(__('Acquisition Date Range'))
                    ->form([
                        Forms\Components\DatePicker::make('acquisition_date_from')
                            ->label(__('From Date')),
                        Forms\Components\DatePicker::make('acquisition_date_to')
                            ->label(__('To Date')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['acquisition_date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('acquisition_date', '>=', $date),
                            )
                            ->when(
                                $data['acquisition_date_to'],
                                fn (Builder $query, $date): Builder => $query->whereDate('acquisition_date', '<=', $date),
                            );
                    }),

                Tables\Filters\Filter::make('cost_range')
                    ->label(__('Acquisition Cost Range'))
                    ->form([
                        Forms\Components\TextInput::make('cost_min')
                            ->label(__('Minimum Cost'))
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('cost_max')
                            ->label(__('Maximum Cost'))
                            ->numeric()
                            ->prefix('$'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['cost_min'],
                                fn (Builder $query, $cost): Builder => $query->where('acquisition_cost', '>=', $cost),
                            )
                            ->when(
                                $data['cost_max'],
                                fn (Builder $query, $cost): Builder => $query->where('acquisition_cost', '<=', $cost),
                            );
                    }),
                ],)
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
            ->emptyStateDescription(__('Create your first asset to start managing your equipment inventory.'))
            ->emptyStateIcon('heroicon-o-cog-6-tooth')
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
            'index' => Pages\ListAMAssets::route('/'),
            'create' => Pages\CreateAMAsset::route('/create'),
            'edit' => Pages\EditAMAsset::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
