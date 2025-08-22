<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AMCostTypeResource\Pages;
use App\Models\AMCostType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AMCostTypeResource extends Resource
{
    protected static ?string $model = AMCostType::class;

    protected static bool $shouldRegisterNavigation = false; // Hide from main navigation

    public static function getNavigationGroup(): ?string
    {
        return __('Settings / Jobs');
    }

    public static function getNavigationSort(): ?int
    {
        return 7;
    }

    public static function getNavigationLabel(): string
    {
        return __('Cost Types');
    }

    public static function getModelLabel(): string
    {
        return __('Cost Type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Cost Types');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('Cost Type Name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
                            })
                            ->helperText(__('Enter the name of the cost type (e.g., Corrective, Investment, Preventive)')),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description(__('Manage cost types for maintenance activities.'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Cost Type'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

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
            ->defaultSort('name', 'asc')
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
            'index' => Pages\ListAMCostTypes::route('/'),
            'create' => Pages\CreateAMCostType::route('/create'),

            'edit' => Pages\EditAMCostType::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
