<?php

namespace App\Livewire;

use App\Models\AMAsset;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;

class AssetEditModal extends Component implements HasForms
{
    use InteractsWithForms;

    public $showModal = false;
    public $assetId = null;
    public $asset = null;

    public function mount()
    {
        $this->form = $this->makeForm();
    }

    protected $listeners = ['open-asset-edit-modal' => 'openModal'];

    public function openModal($assetId)
    {
        $this->assetId = $assetId;
        $this->asset = AMAsset::find($assetId);
        
        if ($this->asset) {
            $this->form->fill($this->asset->toArray());
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->assetId = null;
        $this->asset = null;
        $this->form->fill([]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Basic Information'))
                    ->schema([
                        TextInput::make('maintenance_asset')
                            ->label(__('Asset ID'))
                            ->required()
                            ->unique(table: 'a_m_assets', ignoreRecord: $this->asset)
                            ->maxLength(255),

                        TextInput::make('name')
                            ->label(__('Asset Name'))
                            ->required()
                            ->maxLength(255),

                        Select::make('am_asset_type_id')
                            ->label(__('Asset Type'))
                            ->required()
                            ->relationship('assetType', 'maintenance_asset_type')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->maintenance_asset_type} - {$record->name}")
                            ->searchable()
                            ->preload(),

                        Select::make('am_asset_lifecycle_state_id')
                            ->label(__('Lifecycle State'))
                            ->relationship('lifecycleState', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),
            ]);
    }

    public function save()
    {
        $data = $this->form->getState();
        
        $this->asset->update($data);
        
        $this->closeModal();
        
        $this->dispatch('asset-updated');
        
        Notification::make()
            ->title(__('Asset updated successfully'))
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.asset-edit-modal');
    }
} 