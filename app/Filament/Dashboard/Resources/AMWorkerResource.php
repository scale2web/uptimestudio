<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AMWorkerResource\Pages;
use App\Filament\Dashboard\Resources\AMWorkerResource\RelationManagers;
use App\Models\AMWorker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AMWorkerResource extends Resource
{
    protected static ?string $model = AMWorker::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 40;
    
    protected static ?string $navigationLabel = 'Workers';
    
    protected static ?string $modelLabel = 'Worker';
    
    protected static ?string $pluralModelLabel = 'Workers';
    
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('personnel_number')
                            ->label('Personnel Number')
                            ->required()
                            ->unique(ignoreRecord: true, column: 'personnel_number')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('middle_name')
                            ->label('Middle Name')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('last_name_prefix')
                            ->label('Last Name Prefix')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('known_as')
                            ->label('Known As')
                            ->maxLength(255),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Personal Details')
                    ->schema([
                        Forms\Components\DatePicker::make('birthdate')
                            ->label('Birth Date'),
                        
                        Forms\Components\Select::make('gender')
                            ->label('Gender')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ]),
                        
                        Forms\Components\TextInput::make('person_birth_city')
                            ->label('Birth City')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('person_birth_country_region')
                            ->label('Birth Country/Region')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('citizenship_country_region')
                            ->label('Citizenship Country/Region')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('nationality_country_region')
                            ->label('Nationality Country/Region')
                            ->maxLength(255),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Contact & Language')
                    ->schema([
                        Forms\Components\TextInput::make('primary_contact_email')
                            ->label('Primary Contact Email')
                            ->email()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('language_id')
                            ->label('Language ID')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('native_language_id')
                            ->label('Native Language ID')
                            ->maxLength(255),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\TextInput::make('education')
                            ->label('Education')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('ethnic_origin_id')
                            ->label('Ethnic Origin ID')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('personal_title')
                            ->label('Personal Title')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('personal_suffix')
                            ->label('Personal Suffix')
                            ->maxLength(255),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_disabled')
                            ->label('Is Disabled')
                            ->default(false),
                        
                        Forms\Components\Toggle::make('is_full_time_student')
                            ->label('Is Full Time Student')
                            ->default(false),
                        
                        Forms\Components\DatePicker::make('disabled_verification_date')
                            ->label('Disabled Verification Date'),
                        
                        Forms\Components\DatePicker::make('deceased_date')
                            ->label('Deceased Date'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('personnel_number')
                    ->label('Personnel #')
                    ->sortable()
                    ->searchable()
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Full Name')
                    ->sortable()
                    ->searchable()
                    ->badge(),
                
                Tables\Columns\TextColumn::make('worker_groups_count')
                    ->label('Groups')
                    ->counts('workerGroups')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Male' => 'info',
                        'Female' => 'success',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('birthdate')
                    ->label('Birth Date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('primary_contact_email')
                    ->label('Email')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\IconColumn::make('is_disabled')
                    ->label('Disabled')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_full_time_student')
                    ->label('Student')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('ethnic_origin_id')
                    ->label('Ethnic Origin')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
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
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ])
                    ->multiple(),
                
                Tables\Filters\TernaryFilter::make('is_disabled')
                    ->label('Disabled Status'),
                
                Tables\Filters\TernaryFilter::make('is_full_time_student')
                    ->label('Student Status'),
                
                Tables\Filters\SelectFilter::make('ethnic_origin_id')
                    ->label('Ethnic Origin')
                    ->options([
                        'White' => 'White',
                        'Asian' => 'Asian',
                        'Black/African' => 'Black/African',
                        'Hispanic/Latino' => 'Hispanic/Latino',
                        'Native Hawaiian' => 'Native Hawaiian',
                        'Two or More' => 'Two or More',
                        'American Indian' => 'American Indian',
                    ])
                    ->multiple(),
                
                Tables\Filters\Filter::make('birthdate_range')
                    ->label('Birth Date Range')
                    ->form([
                        Forms\Components\DatePicker::make('birthdate_from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('birthdate_to')
                            ->label('To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['birthdate_from'],
                                fn (Builder $query, $date): Builder => $query->where('birthdate', '>=', $date),
                            )
                            ->when(
                                $data['birthdate_to'],
                                fn (Builder $query, $date): Builder => $query->where('birthdate', '<=', $date),
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
            ->defaultSort('last_name', 'asc')
            ->searchable();
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\WorkerGroupsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAMWorkers::route('/'),
            'create' => Pages\CreateAMWorker::route('/create'),
            'view' => Pages\ViewAMWorker::route('/{record}'),
            'edit' => Pages\EditAMWorker::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('tenant_id', \Filament\Facades\Filament::getTenant()->id);
    }
}
