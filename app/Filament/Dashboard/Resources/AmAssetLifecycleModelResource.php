<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AmAssetLifecycleModelResource\Pages;
use App\Filament\Dashboard\Resources\AmAssetLifecycleModelResource\RelationManagers;
use App\Models\AmAssetLifecycleModel;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AmAssetLifecycleModelResource extends Resource
{
    protected static ?string $model = AmAssetLifecycleModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings Hub';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $label = 'Asset Lifecycle Model';

    protected static ?string $pluralLabel = 'Asset Lifecycle Models';

    protected static ?string $navigationLabel = 'Asset Lifecycle Models';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('tenant_id', Filament::getTenant()->id)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('About Asset Lifecycle Models')
                    ->description('Asset Lifecycle Models define the sequence of states that assets go through during their operational lifetime. Each model contains a series of lifecycle states (like NEW, ACTIVE, MAINTENANCE, INACTIVE, DISPOSED) that can be configured with specific permissions and behaviors. You can create different models for different types of assets - for example, a "Critical Asset Lifecycle" for mission-critical equipment or a "Standard Asset Lifecycle" for general assets.')
                    ->icon('heroicon-o-information-circle')
                    ->collapsed()
                    ->schema([
                        Forms\Components\Placeholder::make('help_content')
                            ->hiddenLabel()
                            ->content('
                                **Key Concepts:**
                                • **Model Code**: A unique identifier for this lifecycle model (e.g., STANDARD, CRITICAL, SIMPLE)
                                • **Model Name**: A descriptive name that explains the purpose of this lifecycle model
                                • **State Sequences**: Define the order and transitions between different asset states
                                
                                **Common Use Cases:**
                                • Standard Asset Lifecycle: NEW → ACTIVE → MAINTENANCE → INACTIVE → DISPOSED
                                • Critical Asset Lifecycle: More detailed states with additional approval requirements
                                • Simple Asset Lifecycle: Minimal states for non-critical assets
                                
                                **Next Steps:**
                                After creating a lifecycle model, use the "State Sequences" tab to define the specific states and their order.
                            ')
                    ]),

                Forms\Components\Section::make('Asset Lifecycle Model Information')
                    ->schema([
                        Forms\Components\TextInput::make('lifecycle_model_name')
                            ->label('Model Code')
                            ->required()
                            ->maxLength(100)
                            ->unique(
                                table: AmAssetLifecycleModel::class,
                                column: 'lifecycle_model_name',
                                ignoreRecord: true,
                                modifyRuleUsing: function (\Illuminate\Validation\Rules\Unique $rule, callable $get) {
                                    return $rule->where('tenant_id', Filament::getTenant()->id);
                                }
                            )
                            ->helperText('Unique code for this asset lifecycle model (e.g., STANDARD, CRITICAL)')
                            ->columnSpan(['md' => 1]),

                        Forms\Components\TextInput::make('name')
                            ->label('Model Name')
                            ->required()
                            ->maxLength(100)
                            ->helperText('Descriptive name for this asset lifecycle model')
                            ->columnSpan(['md' => 1]),
                    ])
                    ->columns(['md' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lifecycle_model_name')
                    ->label('Model Code')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Model Name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('sequences_count')
                    ->label('Sequences')
                    ->counts('sequences')
                    ->badge()
                    ->color('secondary'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
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
            ->emptyStateHeading('No Asset Lifecycle Models Yet')
            ->emptyStateDescription('Asset Lifecycle Models define how your assets progress through different states during their operational lifetime. Create your first model to start managing asset lifecycles - you might want to begin with a "Standard Asset Lifecycle" that includes states like NEW, ACTIVE, MAINTENANCE, INACTIVE, and DISPOSED.')
            ->emptyStateIcon('heroicon-o-cog-6-tooth')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create First Lifecycle Model')
                    ->color('primary'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AmAssetLifecycleStateSequenceRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAmAssetLifecycleModels::route('/'),
            'create' => Pages\CreateAmAssetLifecycleModel::route('/create'),
            'edit' => Pages\EditAmAssetLifecycleModel::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', Filament::getTenant()->id);
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tenant_id'] = Filament::getTenant()->id;
        return $data;
    }
}
