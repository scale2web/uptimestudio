<?php
/**
 * Asset Tree Node Partial
 * 
 * This partial renders a single asset node in the tree view.
 * It includes expand/collapse functionality, asset information,
 * and action buttons for editing and viewing.
 */
?>

@if (!$this->search || $this->assetMatchesSearch($asset) || $this->hasMatchingChildren($asset))
    <div class="asset-tree-node" style="margin-left: {{ $level * 20 }}px;">
        <div class="flex items-center space-x-2 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-150 {{ $this->assetMatchesSearch($asset) && $this->search ? 'bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-500' : '' }}">
            
            <!-- Expand/Collapse Button -->
            @if ($asset->children->count() > 0)
                <button wire:click="toggleNode({{ $asset->id }})"
                    class="flex-shrink-0 w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-transform duration-200 {{ $this->isExpanded($asset->id) ? 'rotate-90' : '' }}"
                    title="{{ $this->isExpanded($asset->id) ? __('Collapse') : __('Expand') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @else
                <div class="flex-shrink-0 w-6 h-6"></div>
            @endif

                <!-- Asset Icon -->
                <div
                    class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>

                <!-- Asset Information -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-2">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ $asset->maintenance_asset }}
                        </h4>
                        @if ($asset->children->count() > 0)
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                {{ $asset->children->count() }} {{ __('children') }}
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                        {{ $asset->name }}
                    </p>
                </div>

                <!-- Asset Type Badge -->
                @if ($asset->assetType)
                    <div class="flex-shrink-0">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            {{ $asset->assetType->maintenance_asset_type }}
                        </span>
                    </div>
                @endif

                <!-- Lifecycle State Badge -->
                @if ($asset->lifecycleState)
                    <div class="flex-shrink-0">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                            {{ $asset->lifecycleState->name }}
                        </span>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex-shrink-0 flex items-center space-x-1">
                    <button wire:click="openEditModal({{ $asset->id }})"
                        class="p-1 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300"
                        title="{{ __('Quick Edit') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <a href="{{ route('filament.dashboard.resources.a-m-assets.edit', ['tenant' => \Filament\Facades\Filament::getTenant()->uuid, 'record' => $asset->id]) }}"
                        target="_blank"
                        class="p-1 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300"
                        title="{{ __('Full Edit (New Tab)') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                    <a href="{{ route('filament.dashboard.resources.a-m-assets.edit', ['tenant' => \Filament\Facades\Filament::getTenant()->uuid, 'record' => $asset->id]) }}"
                        class="p-1 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300"
                        title="{{ __('View Asset') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Child Assets -->
            @if ($asset->children->count() > 0)
                @if ($this->isExpanded($asset->id) || ($this->search && $this->hasMatchingChildren($asset)))
                    <div class="ml-6 border-l-2 border-gray-200 dark:border-gray-700">
                        @foreach ($asset->children as $childAsset)
                            @if (!$this->search || $this->assetMatchesSearch($childAsset) || $this->hasMatchingChildren($childAsset))
                                @include('livewire.partials.asset-tree-node', [
                                    'asset' => $childAsset,
                                    'level' => $level + 1,
                                ])
                            @endif
                        @endforeach
                    </div>
                @endif
            @endif

            <!-- Loading indicator for lazy loading -->
            @if ($this->isExpanded($asset->id) && $asset->children->count() == 0)
                <div class="ml-6 p-2">
                    <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>{{ __('Loading children...') }}</span>
                    </div>
                </div>
            @endif
        </div>
    @endif
