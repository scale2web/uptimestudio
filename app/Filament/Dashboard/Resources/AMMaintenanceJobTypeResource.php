<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AMMaintenanceJobTypeResource\Pages;
use App\Models\AMMaintenanceJobType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AMMaintenanceJobTypeResource extends Resource
{
    protected static ?string $model = AMMaintenanceJobType::class;

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Jobs');
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public static function getNavigationLabel(): string
    {
        return __('Job Types');
    }

    public static function getModelLabel(): string
    {
        return __('Job Type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Job Types');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('job_type_code')
                            ->label(__('Job Type Code'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            })
                            ->helperText(__('Unique identifier for this job type within your organization')),

                        Forms\Components\TextInput::make('name')
                            ->label(__('Display Name'))
                            ->required()
                            ->maxLength(255)
                            ->helperText(__('User-friendly name for this job type')),

                        Forms\Components\Textarea::make('description')
                            ->label(__('Description'))
                            ->rows(3)
                            ->maxLength(1000)
                            ->helperText(__('Optional description for this job type')),

                        Forms\Components\Toggle::make('maintenance_stop_required')
                            ->label(__('Maintenance Stop Required'))
                            ->helperText(__('Indicates if this job type requires equipment to be stopped during maintenance'))
                            ->default(false),

                        Forms\Components\Select::make('job_type_category_id')
                            ->label(__('Job Category'))
                            ->required()
                            ->relationship('jobTypeCategory', 'name', function ($query) {
                                return $query->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            })
                            ->searchable()
                            ->preload()
                            ->helperText(__('Select the category this job type belongs to')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage job types and their associated categories for your organization.'))
            ->columns([
                Tables\Columns\TextColumn::make('job_type_code')
                    ->label(__('Job Type Code'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Display Name'))
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),

                Tables\Columns\TextColumn::make('description')
                    ->label(__('Description'))
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(60),

                Tables\Columns\IconColumn::make('maintenance_stop_required')
                    ->label(__('Stop Required'))
                    ->boolean()
                    ->trueIcon('heroicon-o-stop-circle')
                    ->falseIcon('heroicon-o-play-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('jobTypeCategory.name')
                    ->label(__('Job Category'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('secondary'),

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
            ->defaultSort('job_type_code', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('job_type_category_id')
                    ->label(__('Job Category'))
                    ->relationship('jobTypeCategory', 'name', function ($query) {
                        return $query->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                    })
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ], layout: \Filament\Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListAMMaintenanceJobTypes::route('/'),
            'create' => Pages\CreateAMMaintenanceJobType::route('/create'),
            'edit' => Pages\EditAMMaintenanceJobType::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
