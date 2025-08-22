<?php

namespace App\Filament\Dashboard\Resources\AMWorkerGroupResource\RelationManagers;

use App\Models\AMWorker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;

class WorkersRelationManager extends RelationManager
{
    protected static string $relationship = 'workers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('am_worker_id')
                    ->label('Worker')
                    ->options(function () {
                        $tenant = Filament::getTenant();
                        return AMWorker::where('tenant_id', $tenant->id)
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
                Tables\Columns\TextColumn::make('personnel_number')
                    ->label('Personnel Number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('primary_contact_email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added to Group')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->label('Select Workers')
                            ->options(function () {
                                $tenant = Filament::getTenant();
                                $currentWorkerIds = $this->getOwnerRecord()->workers()->pluck('am_workers.id')->toArray();
                                
                                return AMWorker::where('tenant_id', $tenant->id)
                                    ->whereNotIn('id', $currentWorkerIds)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->multiple()
                            ->required(),
                    ])
                    ->preloadRecordSelect()
                    ->label('Add Workers')
                    ->using(function (array $data, string $model): void {
                        $tenant = Filament::getTenant();
                        $workerGroup = $this->getOwnerRecord();
                        
                        // Get the selected worker IDs
                        $workerIds = $data['recordId'] ?? [];
                        if (!is_array($workerIds)) {
                            $workerIds = [$workerIds];
                        }
                        
                        // Attach workers with tenant_id
                        foreach ($workerIds as $workerId) {
                            $workerGroup->workers()->attach($workerId, [
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
                    ->using(function (AMWorker $record): void {
                        $tenant = Filament::getTenant();
                        $workerGroup = $this->getOwnerRecord();
                        
                        $workerGroup->workers()->detach($record->id);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Remove Selected from Group')
                        ->using(function (array $records): void {
                            $tenant = Filament::getTenant();
                            $workerGroup = $this->getOwnerRecord();
                            
                            $workerIds = collect($records)->pluck('id')->toArray();
                            $workerGroup->workers()->detach($workerIds);
                        }),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }
}
