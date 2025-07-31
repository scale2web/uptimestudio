<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AmFunctionalLocationTypeResource\Pages;
use App\Models\AmFunctionalLocationType;
use App\Models\AmAssetLifecycleModel;
use App\Models\AmAssetType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AmFunctionalLocationTypeResource extends Resource
{
    protected static ?string $model = AmFunctionalLocationType::class;

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Functional Locations');
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function getNavigationLabel(): string
    {
        return __('Location Types');
    }

    public static function getModelLabel(): string
    {
        return __('Functional Location Type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Functional Location Types');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('functional_location_type')
                            ->label(__('Location Type Code'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            })
                            ->helperText(__('Unique identifier for this functional location type within your organization')),

                        Forms\Components\TextInput::make('name')
                            ->label(__('Display Name'))
                            ->required()
                            ->maxLength(255)
                            ->helperText(__('User-friendly name for this functional location type')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Configuration'))
                    ->schema([
                        Forms\Components\Select::make('am_asset_lifecycle_model_id')
                            ->label(__('Asset Lifecycle Model'))
                            ->required()
                            ->relationship('assetLifecycleModel', 'lifecycle_model_name')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->lifecycle_model_name} - {$record->name}")
                            ->searchable()
                            ->preload()
                            ->helperText(__('Select the lifecycle model that defines the states for assets in this location type')),

                        Forms\Components\Select::make('am_asset_type_id')
                            ->label(__('Asset Type (Optional)'))
                            ->relationship('assetType', 'maintenance_asset_type')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->maintenance_asset_type} - {$record->name}")
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText(__('Optionally specify a default asset type for this location type')),

                        Forms\Components\Toggle::make('allow_multiple_installed_assets')
                            ->label(__('Allow Multiple Installed Assets'))
                            ->default(false)
                            ->helperText(__('Enable to allow multiple assets to be installed at locations of this type')),

                        Forms\Components\Toggle::make('update_asset_dimension')
                            ->label(__('Update Asset Dimension'))
                            ->default(false)
                            ->helperText(__('Enable to automatically update asset dimensions when assets are installed at this location type')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage functional location types and their configuration for your organization.'))
            ->columns([
                Tables\Columns\TextColumn::make('functional_location_type')
                    ->label(__('Location Type Code'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Display Name'))
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),

                Tables\Columns\TextColumn::make('assetLifecycleModel.lifecycle_model_name')
                    ->label(__('Lifecycle Model'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('secondary'),

                Tables\Columns\TextColumn::make('assetType.maintenance_asset_type')
                    ->label(__('Asset Type'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->placeholder(__('Not specified')),

                Tables\Columns\IconColumn::make('allow_multiple_installed_assets')
                    ->label(__('Multiple Assets'))
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('update_asset_dimension')
                    ->label(__('Update Dimensions'))
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(config('app.datetime_format'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime(config('app.datetime_format'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('functional_location_type', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('am_asset_lifecycle_model_id')
                    ->label(__('Lifecycle Model'))
                    ->relationship('assetLifecycleModel', 'lifecycle_model_name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('am_asset_type_id')
                    ->label(__('Asset Type'))
                    ->relationship('assetType', 'maintenance_asset_type')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('allow_multiple_installed_assets')
                    ->label(__('Multiple Assets'))
                    ->boolean()
                    ->trueLabel(__('Allowed'))
                    ->falseLabel(__('Not Allowed'))
                    ->native(false),

                Tables\Filters\TernaryFilter::make('update_asset_dimension')
                    ->label(__('Update Dimensions'))
                    ->boolean()
                    ->trueLabel(__('Enabled'))
                    ->falseLabel(__('Disabled'))
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListAmFunctionalLocationTypes::route('/'),
            'create' => Pages\CreateAmFunctionalLocationType::route('/create'),
            'edit' => Pages\EditAmFunctionalLocationType::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
