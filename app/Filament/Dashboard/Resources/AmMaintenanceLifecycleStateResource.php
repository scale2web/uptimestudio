<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AmMaintenanceLifecycleStateResource\Pages;
use App\Models\AmMaintenanceLifecycleState;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AmMaintenanceLifecycleStateResource extends Resource
{
    protected static ?string $model = AmMaintenanceLifecycleState::class;

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Maintenance Requests');
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
        return __('Maintenance Lifecycle State');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Maintenance Lifecycle States');
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
                            ->maxLength(20)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            }),
                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(100),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Permissions'))
                    ->schema([
                        Forms\Components\Toggle::make('allow_create_maintenance_orders')
                            ->label(__('Allow Create Maintenance Orders'))
                            ->default(true),
                        Forms\Components\Toggle::make('allow_create_preventive_orders')
                            ->label(__('Allow Create Preventive Orders'))
                            ->default(true),
                        Forms\Components\Toggle::make('allow_delete_maintenance_request')
                            ->label(__('Allow Delete Maintenance Request'))
                            ->default(false),
                        Forms\Components\Toggle::make('allow_installation')
                            ->label(__('Allow Installation'))
                            ->default(true),
                        Forms\Components\Toggle::make('allow_removal')
                            ->label(__('Allow Removal'))
                            ->default(false),
                        Forms\Components\Toggle::make('allow_rename_maintenance_request')
                            ->label(__('Allow Rename Maintenance Request'))
                            ->default(true),
                        Forms\Components\Toggle::make('maintenance_request_active')
                            ->label(__('Maintenance Request Active'))
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage maintenance lifecycle states for your organization.'))
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
                Tables\Columns\IconColumn::make('maintenance_request_active')
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
                Tables\Columns\IconColumn::make('allow_delete_maintenance_request')
                    ->label(__('Delete Request'))
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
                Tables\Columns\IconColumn::make('allow_rename_maintenance_request')
                    ->label(__('Rename Request'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('lifecycle_state', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('maintenance_request_active')
                    ->label(__('Active Status'))
                    ->boolean()
                    ->trueLabel(__('Active'))
                    ->falseLabel(__('Inactive'))
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
            'index' => Pages\ListAmMaintenanceLifecycleStates::route('/'),
            'create' => Pages\CreateAmMaintenanceLifecycleState::route('/create'),
            'edit' => Pages\EditAmMaintenanceLifecycleState::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
