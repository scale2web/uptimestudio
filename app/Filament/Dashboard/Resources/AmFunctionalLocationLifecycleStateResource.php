<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource\Pages;
use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource\RelationManagers;
use App\Models\AmFunctionalLocationLifecycleState;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AmFunctionalLocationLifecycleStateResource extends Resource
{
    protected static ?string $model = AmFunctionalLocationLifecycleState::class;

    //protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Functional locations');
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
        return __('Functional Location Lifecycle State');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Functional Location Lifecycle States');
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
                        Forms\Components\TextInput::make('maintenance_asset_lifecycle_state_id')
                            ->label(__('Maintenance Asset Lifecycle State ID'))
                            ->numeric()
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Location Permissions'))
                    ->schema([
                        Forms\Components\Toggle::make('allow_delete_location')
                            ->label(__('Allow Delete Location'))
                            ->default(false),
                        Forms\Components\Toggle::make('allow_install_maintenance_assets')
                            ->label(__('Allow Install Maintenance Assets'))
                            ->default(false),
                        Forms\Components\Toggle::make('allow_new_sub_locations')
                            ->label(__('Allow New Sub Locations'))
                            ->default(false),
                        Forms\Components\Toggle::make('allow_rename_location')
                            ->label(__('Allow Rename Location'))
                            ->default(false),
                        Forms\Components\Toggle::make('create_location_maintenance_asset')
                            ->label(__('Create Location Maintenance Asset'))
                            ->default(false),
                        Forms\Components\Toggle::make('functional_location_active')
                            ->label(__('Functional Location Active'))
                            ->default(false),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage AM functional location lifecycle states for your organization.'))
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
                Tables\Columns\IconColumn::make('functional_location_active')
                    ->label(__('Active'))
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('allow_delete_location')
                    ->label(__('Delete'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('allow_install_maintenance_assets')
                    ->label(__('Install Assets'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('allow_new_sub_locations')
                    ->label(__('New Sub Locations'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('allow_rename_location')
                    ->label(__('Rename'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('create_location_maintenance_asset')
                    ->label(__('Create Asset'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('maintenance_asset_lifecycle_state_id')
                    ->label(__('Asset Lifecycle State ID'))
                    ->numeric()
                    ->sortable()
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
                Tables\Filters\TernaryFilter::make('functional_location_active')
                    ->label(__('Functional Location Active'))
                    ->boolean()
                    ->trueLabel(__('Active'))
                    ->falseLabel(__('Inactive'))
                    ->native(false),
                Tables\Filters\TernaryFilter::make('allow_delete_location')
                    ->label(__('Allow Delete Location'))
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
            'index' => Pages\ListAmFunctionalLocationLifecycleStates::route('/'),
            'create' => Pages\CreateAmFunctionalLocationLifecycleState::route('/create'),
            'edit' => Pages\EditAmFunctionalLocationLifecycleState::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
