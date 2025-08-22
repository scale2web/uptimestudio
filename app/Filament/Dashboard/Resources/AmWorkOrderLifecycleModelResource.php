<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AmWorkOrderLifecycleModelResource\Pages;
use App\Models\AmWorkOrderLifecycleModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AmWorkOrderLifecycleModelResource extends Resource
{
    protected static ?string $model = AmWorkOrderLifecycleModel::class;

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Lifecycle');
    }

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function getNavigationLabel(): string
    {
        return __('Work Order Lifecycle Models');
    }

    public static function getModelLabel(): string
    {
        return __('Work Order Lifecycle Model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Work Order Lifecycle Models');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('lifecycle_model_name')
                            ->label(__('Lifecycle Model Name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            })
                            ->helperText(__('Unique identifier for this lifecycle model')),

                        Forms\Components\TextInput::make('name')
                            ->label(__('Display Name'))
                            ->required()
                            ->maxLength(255)
                            ->helperText(__('User-friendly name for this lifecycle model')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage work order lifecycle models for your organization.'))
            ->columns([
                Tables\Columns\TextColumn::make('lifecycle_model_name')
                    ->label(__('Model Name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Display Name'))
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),

                Tables\Columns\TextColumn::make('lifecycleStates_count')
                    ->label(__('Lifecycle States'))
                    ->counts('lifecycleStates')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('sequences_count')
                    ->label(__('Sequences'))
                    ->counts('sequences')
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
            ->defaultSort('lifecycle_model_name', 'asc')
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
            'index' => Pages\ListAmWorkOrderLifecycleModels::route('/'),
            'create' => Pages\CreateAmWorkOrderLifecycleModel::route('/create'),
            'edit' => Pages\EditAmWorkOrderLifecycleModel::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
