<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AMWorkerGroupResource\Pages;
use App\Filament\Dashboard\Resources\AMWorkerGroupResource\RelationManagers;
use App\Models\AMWorkerGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AMWorkerGroupResource extends Resource
{
    protected static ?string $model = AMWorkerGroup::class;

    //protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('Worker Groups');
    }

    public static function getModelLabel(): string
    {
        return __('Worker Group');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Worker Groups');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('worker_group')
                    ->label(__('Worker Group'))
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Electrical'),
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Electrical workers'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('worker_group')
                    ->label(__('Worker Group'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('workers_count')
                    ->label(__('Workers'))
                    ->counts('workers')
                    ->sortable(),
                Tables\Columns\TextColumn::make('workers')
                    ->label(__('Worker Names'))
                    ->getStateUsing(function ($record) {
                        return $record->workers()->pluck('name')->toArray();
                    })
                    ->badge()
                    ->separator(',')
                    ->color('success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('worker_group', 'asc')
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
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\WorkersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAMWorkerGroups::route('/'),
            'create' => Pages\CreateAMWorkerGroup::route('/create'),
            'edit' => Pages\EditAMWorkerGroup::route('/{record}/edit'),
        ];
    }
}
