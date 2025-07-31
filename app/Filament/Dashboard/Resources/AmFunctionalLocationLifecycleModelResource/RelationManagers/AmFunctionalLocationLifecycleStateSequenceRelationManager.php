<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource\RelationManagers;

use App\Models\AmFunctionalLocationLifecycleModel;
use App\Models\AmFunctionalLocationLifecycleState;
use App\Models\AmFunctionalLocationLifecycleStateSequence;
use App\Models\Tenant;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AmFunctionalLocationLifecycleStateSequenceRelationManager extends RelationManager
{
    protected static string $relationship = 'sequences';

    protected static ?string $title = 'Lifecycle State Sequences';

    protected static ?string $modelLabel = 'Lifecycle State Sequence';

    protected static ?string $pluralModelLabel = 'Lifecycle State Sequences';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Lifecycle State Selection')
                    ->schema([
                        Forms\Components\Select::make('lifecycle_state_id')
                            ->label('Lifecycle State')
                            ->required()
                            ->options(function (string $operation, ?Model $record = null) {
                                /** @var Tenant $tenant */
                                $tenant = Filament::getTenant();

                                // Get lifecycle states that are already linked to this model
                                $linkedStateIds = $this->getOwnerRecord()
                                    ->sequences()
                                    ->pluck('lifecycle_state_id')
                                    ->toArray();

                                // For edit operations, include the current record's state
                                if ($operation === 'edit' && $record instanceof AmFunctionalLocationLifecycleStateSequence) {
                                    $linkedStateIds = array_filter($linkedStateIds, fn($id) => $id !== $record->lifecycle_state_id);
                                }

                                // Return only unlinked lifecycle states
                                return AmFunctionalLocationLifecycleState::where('tenant_id', $tenant->id)
                                    ->whereNotIn('id', $linkedStateIds)
                                    ->pluck('lifecycle_state', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->helperText('Only shows lifecycle states not yet added to this sequence')
                            ->columnSpan(['md' => 1]),

                        Forms\Components\TextInput::make('line')
                            ->label('Sequence Order')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(function () {
                                $maxLine = $this->getOwnerRecord()
                                    ->sequences()
                                    ->max('line');
                                return ($maxLine ?? 0) + 1;
                            })
                            ->helperText('Order in which this state appears in the lifecycle')
                            ->columnSpan(['md' => 1]),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Placeholder::make('current_sequences')
                            ->label('Current Sequence Count')
                            ->content(function () {
                                $sequenceCount = $this->getOwnerRecord()->sequences()->count();
                                /** @var Tenant $tenant */
                                $tenant = Filament::getTenant();
                                $totalStates = AmFunctionalLocationLifecycleState::where('tenant_id', $tenant->id)->count();
                                $availableStates = $totalStates - $sequenceCount;

                                return $sequenceCount . ' state(s) configured, ' . $availableStates . ' available to add';
                            }),
                    ])
                    ->hidden(fn(string $operation) => $operation === 'create'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('line')
            ->columns([
                Tables\Columns\TextColumn::make('line')
                    ->label('Order')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('lifecycleState.lifecycle_state')
                    ->label('State Code')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('secondary'),

                Tables\Columns\TextColumn::make('lifecycleState.name')
                    ->label('State Name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('lifecycleState.functional_location_active')
                    ->label('Active')
                    ->badge()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Yes' : 'No'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('lifecycleState.functional_location_active')
                    ->label('Active Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['tenant_id'] = Filament::getTenant()->id;
                        $data['lifecycle_model_id'] = $this->getOwnerRecord()->id;
                        return $data;
                    })
                    ->using(function (array $data, string $model): Model {
                        // Check if this state is already in the sequence
                        $existing = AmFunctionalLocationLifecycleStateSequence::where([
                            'lifecycle_model_id' => $this->getOwnerRecord()->id,
                            'lifecycle_state_id' => $data['lifecycle_state_id'],
                        ])->first();

                        if ($existing) {
                            throw new \Exception('This lifecycle state is already in the sequence.');
                        }

                        // Check if line number is already taken
                        $existingLine = AmFunctionalLocationLifecycleStateSequence::where([
                            'lifecycle_model_id' => $this->getOwnerRecord()->id,
                            'line' => $data['line'],
                        ])->first();

                        if ($existingLine) {
                            throw new \Exception('This line number is already taken. Please choose a different order.');
                        }

                        return AmFunctionalLocationLifecycleStateSequence::create($data);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (AmFunctionalLocationLifecycleStateSequence $record, array $data): array {
                        $data['tenant_id'] = Filament::getTenant()->id;
                        return $data;
                    })
                    ->using(function (AmFunctionalLocationLifecycleStateSequence $record, array $data): Model {
                        // Check if line number is already taken by another record
                        $existingLine = AmFunctionalLocationLifecycleStateSequence::where([
                            'lifecycle_model_id' => $this->getOwnerRecord()->id,
                            'line' => $data['line'],
                        ])->where('id', '!=', $record->id)->first();

                        if ($existingLine) {
                            throw new \Exception('This line number is already taken. Please choose a different order.');
                        }

                        $record->update($data);
                        return $record;
                    }),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('line')
            ->reorderable('line')
            ->paginatedWhileReordering()
            ->emptyStateHeading('No Lifecycle States Configured')
            ->emptyStateDescription('Add lifecycle states to define the sequence for this model.')
            ->emptyStateIcon('heroicon-o-arrow-path');
    }

    /**
     * Override reordering to handle composite unique constraint properly
     */
    public function reorderTable(array $order): void
    {
        DB::transaction(function () use ($order) {
            // Get the owner record (the lifecycle model)
            /** @var AmFunctionalLocationLifecycleModel $lifecycleModel */
            $lifecycleModel = $this->getOwnerRecord();

            // Uncomment below for debugging reorder operations
            // Log::info('Reorder attempt', [
            //     'order' => $order,
            //     'lifecycle_model_id' => $lifecycleModel->id,
            //     'tenant_id' => Filament::getTenant()->id
            // ]);

            // The $order array contains record IDs in the desired order
            // Each position in the array represents the new line number (1-based)
            $updates = [];
            foreach ($order as $position => $recordId) {
                // Convert position to 1-based line number
                $newLineNumber = $position + 1;
                $updates[$recordId] = $newLineNumber;
            }

            // Uncomment below for debugging updates
            // Log::info('Updates to apply', ['updates' => $updates]);

            if (empty($updates)) {
                // Log::warning('No updates to apply - skipping reorder');
                return;
            }

            // Get the records we need to update
            $recordsToUpdate = AmFunctionalLocationLifecycleStateSequence::whereIn('id', array_keys($updates))
                ->where('lifecycle_model_id', $lifecycleModel->id)
                ->get()
                ->keyBy('id');

            // First, temporarily move all records to very high line numbers to avoid conflicts
            $tempLineStart = 10000;
            foreach ($updates as $recordId => $newLineNumber) {
                if (isset($recordsToUpdate[$recordId])) {
                    $record = $recordsToUpdate[$recordId];
                    $tempLine = $tempLineStart + $newLineNumber;
                    $record->update(['line' => $tempLine]);
                    // Log::info("Temp update: Record {$recordId} from line {$record->line} to {$tempLine}");
                }
            }

            // Then update to the actual target line numbers
            foreach ($updates as $recordId => $newLineNumber) {
                if (isset($recordsToUpdate[$recordId])) {
                    $record = $recordsToUpdate[$recordId];
                    $record->update(['line' => $newLineNumber]);
                    // Log::info("Final update: Record {$recordId} to line {$newLineNumber}");
                }
            }

            // Log::info('Reorder completed successfully');
        });
    }
    public function isReadOnly(): bool
    {
        return false;
    }
}
