<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AMMaintenanceJobTypeCategoryResource\Pages;
use App\Models\AMMaintenanceJobTypeCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;

class AMMaintenanceJobTypeCategoryResource extends Resource
{
    protected static ?string $model = AMMaintenanceJobTypeCategory::class;

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Jobs');
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function getNavigationLabel(): string
    {
        return __('Job Type Categories');
    }

    public static function getModelLabel(): string
    {
        return __('Job Type Category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Job Type Categories');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('job_type_category_code')
                            ->label(__('Job Type Category Code'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            })
                            ->helperText(__('Unique identifier for this job type category within your organization')),

                        Forms\Components\TextInput::make('name')
                            ->label(__('Display Name'))
                            ->required()
                            ->maxLength(255)
                            ->helperText(__('User-friendly name for this job type category')),

                        Forms\Components\Textarea::make('description')
                            ->label(__('Description'))
                            ->rows(3)
                            ->maxLength(1000)
                            ->helperText(__('Optional description for this job type category')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage job type categories for maintenance jobs in your organization.'))
            ->columns([
                Tables\Columns\TextColumn::make('job_type_category_code')
                    ->label(__('Category Code'))
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
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('jobTypes_count')
                    ->label(__('Job Types'))
                    ->counts('jobTypes')
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
            ->defaultSort('job_type_category_code', 'asc')
            ->filters([
                //
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
            ])
            ;
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
            'index' => Pages\ListAMMaintenanceJobTypeCategories::route('/'),
            'create' => Pages\CreateAMMaintenanceJobTypeCategory::route('/create'),
            'edit' => Pages\EditAMMaintenanceJobTypeCategory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
