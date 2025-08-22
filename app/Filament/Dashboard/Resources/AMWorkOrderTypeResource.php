<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AMWorkOrderTypeResource\Pages;
use App\Models\AMWorkOrderType;
use App\Models\AMCostType;
use App\Models\AmWorkOrderLifecycleModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class AMWorkOrderTypeResource extends Resource
{
    protected static ?string $model = AMWorkOrderType::class;

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Jobs');
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getNavigationLabel(): string
    {
        return __('Work Order Types');
    }

    public static function getModelLabel(): string
    {
        return __('Work Order Type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Work Order Types');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('work_order_type')
                            ->label(__('Work Order Type Code'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            })
                            ->helperText(__('Unique identifier for this work order type within your organization')),

                        Forms\Components\TextInput::make('name')
                            ->label(__('Display Name'))
                            ->required()
                            ->maxLength(255)
                            ->helperText(__('User-friendly name for this work order type')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Relationships'))
                    ->schema([
                        Forms\Components\Select::make('am_cost_type_id')
                            ->label(__('Cost Type'))
                            ->required()
                            ->options(function () {
                                return AMCostType::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->helperText(__('Select the cost type associated with this work order type')),

                        Forms\Components\Select::make('am_work_order_lifecycle_model_id')
                            ->label(__('Work Order Lifecycle Model'))
                            ->required()
                            ->options(function () {
                                return AmWorkOrderLifecycleModel::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                                    ->pluck('lifecycle_model_name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->helperText(__('Select the lifecycle model that defines the states for this work order type')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Mandatory Fields'))
                    ->schema([
                        Forms\Components\Toggle::make('fault_cause_mandatory')
                            ->label(__('Fault Cause Mandatory'))
                            ->default(false)
                            ->helperText(__('Require fault cause to be specified for this work order type')),

                        Forms\Components\Toggle::make('fault_remedy_mandatory')
                            ->label(__('Fault Remedy Mandatory'))
                            ->default(false)
                            ->helperText(__('Require fault remedy to be specified for this work order type')),

                        Forms\Components\Toggle::make('fault_symptom_mandatory')
                            ->label(__('Fault Symptom Mandatory'))
                            ->default(false)
                            ->helperText(__('Require fault symptom to be specified for this work order type')),

                        Forms\Components\Toggle::make('production_stop_mandatory')
                            ->label(__('Production Stop Mandatory'))
                            ->default(false)
                            ->helperText(__('Require production stop information for this work order type')),

                        Forms\Components\Toggle::make('schedule_one_worker')
                            ->label(__('Schedule One Worker'))
                            ->default(false)
                            ->helperText(__('Automatically schedule one worker for this work order type')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage work order types and their configuration for your organization.'))
            ->columns([
                Tables\Columns\TextColumn::make('work_order_type')
                    ->label(__('Work Order Type Code'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Display Name'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('costType.name')
                    ->label(__('Cost Type'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('workOrderLifecycleModel.lifecycle_model_name')
                    ->label(__('Lifecycle Model'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('secondary'),

                Tables\Columns\IconColumn::make('fault_cause_mandatory')
                    ->label(__('Fault Cause'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('fault_remedy_mandatory')
                    ->label(__('Fault Remedy'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('fault_symptom_mandatory')
                    ->label(__('Fault Symptom'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('production_stop_mandatory')
                    ->label(__('Production Stop'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('schedule_one_worker')
                    ->label(__('One Worker'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

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
                Tables\Filters\SelectFilter::make('am_cost_type_id')
                    ->label(__('Cost Type'))
                    ->options(function () {
                        return AMCostType::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('am_work_order_lifecycle_model_id')
                    ->label(__('Lifecycle Model'))
                    ->options(function () {
                        return AmWorkOrderLifecycleModel::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                            ->pluck('lifecycle_model_name', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('fault_cause_mandatory')
                    ->label(__('Fault Cause Mandatory'))
                    ->boolean()
                    ->trueLabel(__('Required'))
                    ->falseLabel(__('Optional'))
                    ->native(false),

                Tables\Filters\TernaryFilter::make('fault_remedy_mandatory')
                    ->label(__('Fault Remedy Mandatory'))
                    ->boolean()
                    ->trueLabel(__('Required'))
                    ->falseLabel(__('Optional'))
                    ->native(false),

                Tables\Filters\TernaryFilter::make('fault_symptom_mandatory')
                    ->label(__('Fault Symptom Mandatory'))
                    ->boolean()
                    ->trueLabel(__('Required'))
                    ->falseLabel(__('Optional'))
                    ->native(false),

                Tables\Filters\TernaryFilter::make('production_stop_mandatory')
                    ->label(__('Production Stop Mandatory'))
                    ->boolean()
                    ->trueLabel(__('Required'))
                    ->falseLabel(__('Optional'))
                    ->native(false),

                Tables\Filters\TernaryFilter::make('schedule_one_worker')
                    ->label(__('Schedule One Worker'))
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
            ->defaultSort('work_order_type', 'asc')
            ->emptyStateHeading(__('No Work Order Types Found'))
            ->emptyStateDescription(__('Create your first work order type to start managing your maintenance workflows.'))
            ->emptyStateIcon('heroicon-o-wrench-screwdriver')
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
            'index' => Pages\ListAMWorkOrderTypes::route('/'),
            'create' => Pages\CreateAMWorkOrderType::route('/create'),
            'edit' => Pages\EditAMWorkOrderType::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
