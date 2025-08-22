<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AMWorkOrderResource\Pages;
use App\Models\AMWorkOrder;
use App\Models\AMCostType;
use App\Models\AmWorkOrderLifecycleState;
use App\Models\AMWorker;
use App\Models\AMCriticality;
use App\Models\AMWorkerGroup;
use App\Models\AMWorkOrderType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Navigation\NavigationItem;

class AMWorkOrderResource extends Resource
{
    protected static ?string $model = AMWorkOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Jobs';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Work Orders';

    public static function getModelLabel(): string
    {
        return 'Work Order';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Work Orders';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('work_order_id')
                            ->label('Work Order ID')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            })
                            ->helperText('Unique identifier for this work order'),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Whether this work order is currently active'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Timing')
                    ->schema([
                        Forms\Components\DateTimePicker::make('expected_start')
                            ->label('Expected Start')
                            ->helperText('When the work is expected to begin'),

                        Forms\Components\DateTimePicker::make('expected_end')
                            ->label('Expected End')
                            ->helperText('When the work is expected to complete'),

                        Forms\Components\DateTimePicker::make('scheduled_start')
                            ->label('Scheduled Start')
                            ->helperText('When the work is scheduled to begin'),

                        Forms\Components\DateTimePicker::make('scheduled_end')
                            ->label('Scheduled End')
                            ->helperText('When the work is scheduled to complete'),

                        Forms\Components\DateTimePicker::make('actual_start')
                            ->label('Actual Start')
                            ->helperText('When the work actually began'),

                        Forms\Components\DateTimePicker::make('actual_end')
                            ->label('Actual End')
                            ->helperText('When the work actually completed'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Classification')
                    ->schema([
                        Forms\Components\Select::make('am_work_order_type_id')
                            ->label('Work Order Type')
                            ->required()
                            ->relationship('workOrderType', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Type of maintenance work'),

                        Forms\Components\Select::make('am_cost_type_id')
                            ->label('Cost Type')
                            ->relationship('costType', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Cost classification for this work order'),

                        Forms\Components\Select::make('am_criticality_id')
                            ->label('Service Level (Criticality)')
                            ->relationship('serviceLevel', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Priority level for this work order'),

                        Forms\Components\Select::make('am_work_order_lifecycle_state_id')
                            ->label('Current State')
                            ->required()
                            ->relationship('workOrderLifecycleState', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Current lifecycle state of the work order'),

                        Forms\Components\Select::make('next_work_order_lifecycle_state_id')
                            ->label('Next State')
                            ->relationship('nextWorkOrderLifecycleState', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Next planned lifecycle state'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Workforce')
                    ->schema([
                        Forms\Components\Select::make('responsible_worker_personnel_number')
                            ->label('Responsible Worker')
                            ->relationship('responsibleWorker', 'personnel_number')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->personnel_number} - {$record->full_name}")
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Worker responsible for this work order'),

                        Forms\Components\Select::make('scheduled_worker_personnel_number')
                            ->label('Scheduled Worker')
                            ->relationship('scheduledWorker', 'personnel_number')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->personnel_number} - {$record->full_name}")
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Worker scheduled to perform this work'),

                        Forms\Components\Select::make('am_worker_group_id')
                            ->label('Worker Group')
                            ->relationship('workerGroup', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Group of workers assigned to this work order'),

                        Forms\Components\Toggle::make('is_work_order_scheduled_for_single_worker')
                            ->label('Single Worker Assignment')
                            ->default(false)
                            ->helperText('Whether this work order is assigned to a single worker'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Relationships')
                    ->schema([
                        Forms\Components\Select::make('parent_work_order_id')
                            ->label('Parent Work Order')
                            ->relationship('parentWorkOrder', 'work_order_id')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->work_order_id} - {$record->description}")
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Parent work order if this is a sub-task'),

                        Forms\Components\TextInput::make('order_billing_customer_account_number')
                            ->label('Billing Customer Account')
                            ->maxLength(255)
                            ->helperText('Customer account for billing purposes'),

                        Forms\Components\TextInput::make('order_project_contract_id')
                            ->label('Project Contract ID')
                            ->maxLength(255)
                            ->helperText('Associated project contract identifier'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description('Manage work orders for asset maintenance and repairs.')
            ->filtersLayout(\Filament\Tables\Enums\FiltersLayout::AboveContent)
            ->filters([
                Tables\Filters\SelectFilter::make('am_work_order_type_id')
                    ->label('Work Order Type')
                    ->relationship('workOrderType', 'name', function (Builder $query) {
                        return $query->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                    })
                    ->searchable()
                    ->preload()
                    ->placeholder('All Types'),

                Tables\Filters\SelectFilter::make('am_work_order_lifecycle_state_id')
                    ->label('Lifecycle State')
                    ->relationship('workOrderLifecycleState', 'name', function (Builder $query) {
                        return $query->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                    })
                    ->searchable()
                    ->preload()
                    ->placeholder('All States'),

                Tables\Filters\SelectFilter::make('am_cost_type_id')
                    ->label('Cost Type')
                    ->relationship('costType', 'name', function (Builder $query) {
                        return $query->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                    })
                    ->searchable()
                    ->preload()
                    ->placeholder('All Cost Types'),

                Tables\Filters\TernaryFilter::make('active')
                    ->label('Active Status')
                    ->boolean()
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->native(false)
                    ->placeholder('All Statuses'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('work_order_id')
                    ->label('Work Order ID')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->description;
                    }),

                Tables\Columns\TextColumn::make('workOrderType.name')
                    ->label('Type')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('workOrderLifecycleState.name')
                    ->label('State')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(function ($record) {
                        return match($record->workOrderLifecycleState?->lifecycle_state) {
                            'New' => 'info',
                            'Scheduled' => 'warning',
                            'InProgress' => 'success',
                            'Completed' => 'success',
                            'Cancelled' => 'danger',
                            default => 'gray',
                        };
                    }),

                Tables\Columns\TextColumn::make('expected_start')
                    ->label('Expected Start')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('expected_end')
                    ->label('Expected End')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('responsibleWorker.full_name')
                    ->label('Responsible Worker')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('workerGroup.name')
                    ->label('Worker Group')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('active')
                    ->label('Active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('work_order_id', 'desc')
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
            'index' => Pages\ListAMWorkOrders::route('/'),
            'create' => Pages\CreateAMWorkOrder::route('/create'),
            'edit' => Pages\EditAMWorkOrder::route('/{record}/edit'),
            'scheduling' => Pages\WorkOrderScheduling::route('/scheduling'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }

    public static function getNavigationItems(): array
    {
        return [
            ...parent::getNavigationItems(),
            NavigationItem::make('Work Order Scheduling')
                ->url(static::getUrl('scheduling'))
                ->icon('heroicon-o-calendar')
                ->group('Jobs')
                ->sort(2),
        ];
    }
}
