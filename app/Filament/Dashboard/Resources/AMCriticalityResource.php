<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AMCriticalityResource\Pages;
use App\Filament\Dashboard\Resources\AMCriticalityResource\RelationManagers;
use App\Models\AMCriticality;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AMCriticalityResource extends Resource
{
    protected static ?string $model = AMCriticality::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 30;
    
    protected static ?string $navigationLabel = 'Criticality';
    
    protected static ?string $modelLabel = 'Criticality';
    
    protected static ?string $pluralModelLabel = 'Criticalities';
    
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Criticality Information')
                    ->schema([
                        Forms\Components\TextInput::make('criticality')
                            ->label('Criticality Level')
                            ->numeric()
                            ->required()
                            ->unique(ignoreRecord: true, columns: ['criticality', 'tenant_id'])
                            ->helperText('Numeric criticality level (e.g., 3, 5, 8)'),
                        
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Human-readable name (e.g., Low, Medium, High)'),
                        
                        Forms\Components\TextInput::make('rating_factor')
                            ->label('Rating Factor')
                            ->numeric()
                            ->required()
                            ->helperText('Numeric rating factor for calculations'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('criticality')
                    ->label('Criticality Level')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Low' => 'success',
                        'Medium' => 'warning',
                        'High' => 'danger',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('rating_factor')
                    ->label('Rating Factor')
                    ->sortable()
                    ->searchable()
                    ->numeric(),
                
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
                Tables\Filters\SelectFilter::make('name')
                    ->label('Criticality Name')
                    ->options([
                        'Low' => 'Low',
                        'Medium' => 'Medium',
                        'High' => 'High',
                    ])
                    ->multiple(),
                
                Tables\Filters\Filter::make('rating_factor_range')
                    ->label('Rating Factor Range')
                    ->form([
                        Forms\Components\TextInput::make('min_rating')
                            ->label('Min Rating')
                            ->numeric()
                            ->placeholder('0'),
                        Forms\Components\TextInput::make('max_rating')
                            ->label('Max Rating')
                            ->numeric()
                            ->placeholder('200'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_rating'],
                                fn (Builder $query, $rating): Builder => $query->where('rating_factor', '>=', $rating),
                            )
                            ->when(
                                $data['max_rating'],
                                fn (Builder $query, $rating): Builder => $query->where('rating_factor', '<=', $rating),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('criticality', 'asc')
            ->searchable();
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
            'index' => Pages\ListAMCriticalities::route('/'),
            'create' => Pages\CreateAMCriticality::route('/create'),
            'view' => Pages\ViewAMCriticality::route('/{record}'),
            'edit' => Pages\EditAMCriticality::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
