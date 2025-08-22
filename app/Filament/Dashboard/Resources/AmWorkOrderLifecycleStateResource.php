<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AmWorkOrderLifecycleStateResource\Pages;
use App\Models\AmWorkOrderLifecycleState;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AmWorkOrderLifecycleStateResource extends Resource
{
    protected static ?string $model = AmWorkOrderLifecycleState::class;

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Lifecycle');
    }

    public static function getNavigationSort(): ?int
    {
        return 6;
    }

    public static function getNavigationLabel(): string
    {
        return __('Work Order Lifecycle States');
    }

    public static function getModelLabel(): string
    {
        return __('Work Order Lifecycle State');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Work Order Lifecycle States');
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
                            })
                            ->helperText(__('Unique identifier for this lifecycle state')),

                        Forms\Components\TextInput::make('name')
                            ->label(__('Display Name'))
                            ->required()
                            ->maxLength(255)
                            ->helperText(__('User-friendly name for this lifecycle state')),

                        Forms\Components\Select::make('lifecycle_model_id')
                            ->label(__('Lifecycle Model'))
                            ->required()
                            ->relationship('lifecycleModel', 'name', function ($query) {
                                return $query->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            })
                            ->searchable()
                            ->preload()
                            ->helperText(__('Select the lifecycle model this state belongs to')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Work Order Settings'))
                    ->schema([
                        Forms\Components\Toggle::make('work_order_active')
                            ->label(__('Work Order Active'))
                            ->helperText(__('Indicates if work orders in this state are active')),

                        Forms\Components\Toggle::make('work_order_allow_delete')
                            ->label(__('Allow Delete'))
                            ->helperText(__('Allow deletion of work orders in this state')),

                        Forms\Components\Toggle::make('work_order_allow_line_delete')
                            ->label(__('Allow Line Delete'))
                            ->helperText(__('Allow deletion of work order lines in this state')),

                        Forms\Components\Toggle::make('work_order_allow_scheduling')
                            ->label(__('Allow Scheduling'))
                            ->helperText(__('Allow scheduling of work orders in this state')),

                        Forms\Components\Toggle::make('work_order_create_job')
                            ->label(__('Create Job'))
                            ->helperText(__('Allow job creation for work orders in this state')),

                        Forms\Components\Toggle::make('work_order_set_actual_start')
                            ->label(__('Set Actual Start'))
                            ->helperText(__('Allow setting actual start time for work orders in this state')),

                        Forms\Components\Toggle::make('work_order_set_actual_end')
                            ->label(__('Set Actual End'))
                            ->helperText(__('Allow setting actual end time for work orders in this state')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Advanced Settings'))
                    ->schema([
                        Forms\Components\Toggle::make('close_activities')
                            ->label(__('Close Activities'))
                            ->helperText(__('Close activities when transitioning to this state')),

                        Forms\Components\Toggle::make('post_work_order_journals')
                            ->label(__('Post Work Order Journals'))
                            ->helperText(__('Post journals when transitioning to this state')),

                        Forms\Components\Toggle::make('maintenance_plan_counter_reset')
                            ->label(__('Maintenance Plan Counter Reset'))
                            ->helperText(__('Reset maintenance plan counters in this state')),

                        Forms\Components\Toggle::make('update_maintenance_asset_bom')
                            ->label(__('Update Maintenance Asset BOM'))
                            ->helperText(__('Update bill of materials for maintenance assets')),

                        Forms\Components\TextInput::make('project_status')
                            ->label(__('Project Status'))
                            ->maxLength(255)
                            ->helperText(__('Project status associated with this state')),

                        Forms\Components\TextInput::make('request_lifecycle_state_id')
                            ->label(__('Request Lifecycle State ID'))
                            ->maxLength(255)
                            ->helperText(__('Associated request lifecycle state')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage work order lifecycle states and their configuration.'))
            ->columns([
                Tables\Columns\TextColumn::make('lifecycle_state')
                    ->label(__('State'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Display Name'))
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),

                Tables\Columns\TextColumn::make('lifecycleModel.name')
                    ->label(__('Lifecycle Model'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('secondary'),

                Tables\Columns\IconColumn::make('work_order_active')
                    ->label(__('Active'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('work_order_allow_delete')
                    ->label(__('Allow Delete'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('project_status')
                    ->label(__('Project Status'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
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
                Tables\Filters\SelectFilter::make('lifecycle_model_id')
                    ->label(__('Lifecycle Model'))
                    ->relationship('lifecycleModel', 'name', function ($query) {
                        return $query->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                    })
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListAmWorkOrderLifecycleStates::route('/'),
            'create' => Pages\CreateAmWorkOrderLifecycleState::route('/create'),
            'edit' => Pages\EditAmWorkOrderLifecycleState::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
