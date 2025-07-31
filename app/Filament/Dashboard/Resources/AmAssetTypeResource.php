<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AmAssetTypeResource\Pages;
use App\Models\AmAssetType;
use App\Models\AmAssetLifecycleModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AmAssetTypeResource extends Resource
{
    protected static ?string $model = AmAssetType::class;

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Assets');
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function getNavigationLabel(): string
    {
        return __('Asset Types');
    }

    public static function getModelLabel(): string
    {
        return __('Asset Type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Asset Types');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('maintenance_asset_type')
                            ->label(__('Asset Type Code'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            })
                            ->helperText(__('Unique identifier for this asset type within your organization')),

                        Forms\Components\TextInput::make('name')
                            ->label(__('Display Name'))
                            ->required()
                            ->maxLength(255)
                            ->helperText(__('User-friendly name for this asset type')),

                        Forms\Components\Select::make('am_asset_lifecycle_model_id')
                            ->label(__('Asset Lifecycle Model'))
                            ->required()
                            ->relationship('assetLifecycleModel', 'lifecycle_model_name')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->lifecycle_model_name} - {$record->name}")
                            ->searchable()
                            ->preload()
                            ->helperText(__('Select the lifecycle model that defines the states for this asset type')),

                        Forms\Components\Toggle::make('calculate_kpi_total')
                            ->label(__('Calculate KPI Total'))
                            ->default(false)
                            ->helperText(__('Enable to include this asset type in KPI calculations')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage asset types and their associated lifecycle models for your organization.'))
            ->columns([
                Tables\Columns\TextColumn::make('maintenance_asset_type')
                    ->label(__('Asset Type Code'))
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

                Tables\Columns\TextColumn::make('assetLifecycleModel.name')
                    ->label(__('Lifecycle Model Name'))
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('calculate_kpi_total')
                    ->label(__('KPI Calculation'))
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
            ->defaultSort('maintenance_asset_type', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('am_asset_lifecycle_model_id')
                    ->label(__('Lifecycle Model'))
                    ->relationship('assetLifecycleModel', 'lifecycle_model_name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('calculate_kpi_total')
                    ->label(__('KPI Calculation'))
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
            'index' => Pages\ListAmAssetTypes::route('/'),
            'create' => Pages\CreateAmAssetType::route('/create'),
            'edit' => Pages\EditAmAssetType::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
