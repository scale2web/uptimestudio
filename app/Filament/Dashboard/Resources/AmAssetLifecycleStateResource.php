<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AmAssetLifecycleStateResource\Pages;
use App\Filament\Dashboard\Resources\AmAssetLifecycleStateResource\RelationManagers;
use App\Models\AmAssetLifecycleState;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AmAssetLifecycleStateResource extends Resource
{
    protected static ?string $model = AmAssetLifecycleState::class;

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Assets');
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getNavigationLabel(): string
    {
        return __('Lifecycle States');
    }

    public static function getModelLabel(): string
    {
        return __('Asset Lifecycle State');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Asset Lifecycle States');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('lifecycle_state')
                            ->label(__('Lifecycle State'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            }),
                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Asset Permissions'))
                    ->schema([
                        Forms\Components\Toggle::make('allow_create_maintenance_orders')
                            ->label(__('Allow Create Maintenance Orders'))
                            ->default(false),
                        Forms\Components\Toggle::make('allow_create_preventive_orders')
                            ->label(__('Allow Create Preventive Orders'))
                            ->default(false),
                        Forms\Components\Toggle::make('allow_delete_asset')
                            ->label(__('Allow Delete Asset'))
                            ->default(false),
                        Forms\Components\Toggle::make('allow_installation')
                            ->label(__('Allow Installation'))
                            ->default(false),
                        Forms\Components\Toggle::make('allow_removal')
                            ->label(__('Allow Removal'))
                            ->default(false),
                        Forms\Components\Toggle::make('allow_rename_asset')
                            ->label(__('Allow Rename Asset'))
                            ->default(false),
                        Forms\Components\Toggle::make('asset_active')
                            ->label(__('Asset Active'))
                            ->default(false),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage AM asset lifecycle states for your organization.'))
            ->columns([
                Tables\Columns\TextColumn::make('lifecycle_state')
                    ->label(__('Lifecycle State'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),
                Tables\Columns\IconColumn::make('asset_active')
                    ->label(__('Active'))
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('allow_create_maintenance_orders')
                    ->label(__('Maintenance Orders'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('allow_create_preventive_orders')
                    ->label(__('Preventive Orders'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('allow_delete_asset')
                    ->label(__('Delete Asset'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('allow_installation')
                    ->label(__('Installation'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('allow_removal')
                    ->label(__('Removal'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('allow_rename_asset')
                    ->label(__('Rename Asset'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->defaultSort('lifecycle_state', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('asset_active')
                    ->label(__('Asset Active'))
                    ->boolean()
                    ->trueLabel(__('Active'))
                    ->falseLabel(__('Inactive'))
                    ->native(false),
                Tables\Filters\TernaryFilter::make('allow_create_maintenance_orders')
                    ->label(__('Allow Maintenance Orders'))
                    ->boolean()
                    ->trueLabel(__('Allowed'))
                    ->falseLabel(__('Not Allowed'))
                    ->native(false),
                Tables\Filters\TernaryFilter::make('allow_delete_asset')
                    ->label(__('Allow Delete Asset'))
                    ->boolean()
                    ->trueLabel(__('Allowed'))
                    ->falseLabel(__('Not Allowed'))
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
            'index' => Pages\ListAmAssetLifecycleStates::route('/'),
            'create' => Pages\CreateAmAssetLifecycleState::route('/create'),
            'edit' => Pages\EditAmAssetLifecycleState::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
