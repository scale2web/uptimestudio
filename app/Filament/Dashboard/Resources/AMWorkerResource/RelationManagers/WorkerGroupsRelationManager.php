<?php

namespace App\Filament\Dashboard\Resources\AMWorkerResource\RelationManagers;

use App\Models\AMWorkerGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;

class WorkerGroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'workerGroups';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('am_worker_group_id')
                    ->label('Worker Group')
                    ->options(function () {
                        $tenant = Filament::getTenant();
                        return AMWorkerGroup::where('tenant_id', $tenant->id)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('worker_group')
                    ->label('Group Code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Group Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added to Group')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->label('Select Worker Groups')
                            ->options(function () {
                                $tenant = Filament::getTenant();
                                $currentGroupIds = $this->getOwnerRecord()->workerGroups()->pluck('am_worker_groups.id')->toArray();
                                
                                return AMWorkerGroup::where('tenant_id', $tenant->id)
                                    ->whereNotIn('id', $currentGroupIds)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->multiple()
                            ->required(),
                    ])
                    ->preloadRecordSelect()
                    ->label('Add to Groups')
                    ->using(function (array $data, string $model): void {
                        $tenant = Filament::getTenant();
                        $worker = $this->getOwnerRecord();
                        
                        // Get the selected group IDs
                        $groupIds = $data['recordId'] ?? [];
                        if (!is_array($groupIds)) {
                            $groupIds = [$groupIds];
                        }
                        
                        // Attach groups with tenant_id
                        foreach ($groupIds as $groupId) {
                            $worker->workerGroups()->attach($groupId, [
                                'tenant_id' => $tenant->id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->label('Remove from Group')
                    ->using(function (AMWorkerGroup $record): void {
                        $tenant = Filament::getTenant();
                        $worker = $this->getOwnerRecord();
                        
                        $worker->workerGroups()->detach($record->id);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Remove Selected from Groups')
                        ->using(function (array $records): void {
                            $tenant = Filament::getTenant();
                            $worker = $this->getOwnerRecord();
                            
                            $groupIds = collect($records)->pluck('id')->toArray();
                            $worker->workerGroups()->detach($groupIds);
                        }),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }
}
