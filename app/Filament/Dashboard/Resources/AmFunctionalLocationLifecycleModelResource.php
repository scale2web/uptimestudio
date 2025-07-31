<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource\Pages;
use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource\RelationManagers;
use App\Models\AmFunctionalLocationLifecycleModel;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AmFunctionalLocationLifecycleModelResource extends Resource
{
    protected static ?string $model = AmFunctionalLocationLifecycleModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $navigationLabel = 'Lifecycle Models';

    protected static ?string $modelLabel = 'Lifecycle Model';

    protected static ?string $pluralModelLabel = 'Lifecycle Models';

    // Hide from navigation - accessed via Settings Hub
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Lifecycle Model Information')
                    ->schema([
                        Forms\Components\TextInput::make('lifecycle_model_name')
                            ->label('Model Name')
                            ->required()
                            ->maxLength(255)
                            ->unique(
                                table: 'am_functional_location_lifecycle_models',
                                column: 'lifecycle_model_name',
                                ignoreRecord: true,
                                modifyRuleUsing: function ($rule, callable $get) {
                                    return $rule->where('tenant_id', Filament::getTenant()->id);
                                }
                            )
                            ->validationAttribute('lifecycle model name')
                            ->helperText('Unique identifier for this lifecycle model (e.g., GLOBAL, INDUSTRIAL)')
                            ->columnSpan(['md' => 1]),

                        Forms\Components\TextInput::make('name')
                            ->label('Display Name')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Human-readable name for this lifecycle model')
                            ->columnSpan(['md' => 1]),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Section::make('Related Lifecycle States')
                    ->schema([
                        Forms\Components\Placeholder::make('lifecycle_states_count')
                            ->label('Associated Lifecycle States')
                            ->content(
                                fn(?AmFunctionalLocationLifecycleModel $record): string =>
                                $record ? $record->lifecycleStates()->count() . ' state(s)' : 'No states yet'
                            ),
                    ])
                    ->hidden(fn(?AmFunctionalLocationLifecycleModel $record) => $record === null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lifecycle_model_name')
                    ->label('Model Name')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Display Name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('lifecycle_states_count')
                    ->label('States')
                    ->counts('lifecycleStates')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('lifecycle_model_name')
            ->searchPlaceholder('Search by model name or display name...');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('tenant_id', Filament::getTenant()->id)
            ->withCount('lifecycleStates');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AmFunctionalLocationLifecycleStateSequenceRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAmFunctionalLocationLifecycleModels::route('/'),
            'create' => Pages\CreateAmFunctionalLocationLifecycleModel::route('/create'),
            'edit' => Pages\EditAmFunctionalLocationLifecycleModel::route('/{record}/edit'),
        ];
    }
}
