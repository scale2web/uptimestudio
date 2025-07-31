<div class="space-y-4">
    <!-- Search and Filter Controls -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <div class="space-y-4">
            <!-- Search Section -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    {{ __('Search Assets') }}
                </label>
                <div class="flex space-x-2">
                    <input type="text" id="search" wire:model.live="search"
                        placeholder="{{ __('Search by Asset ID or Name...') }}"
                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <button wire:click="performSearch"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        {{ __('Search') }}
                    </button>
                    @if ($search)
                        <button wire:click="clearSearch"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            {{ __('Clear') }}
                        </button>
                    @endif
                </div>
            </div>

            <!-- Filter Dropdowns Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Asset Type Section -->
                <div>
                    <label for="assetType" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Asset Type') }}
                    </label>
                    <select id="assetType" wire:model.live="selectedAssetType"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">{{ __('All Types') }}</option>
                        @foreach (\App\Models\AmAssetType::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->get() as $type)
                            <option value="{{ $type->id }}">{{ $type->maintenance_asset_type }} -
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Lifecycle State Section -->
                <div>
                    <label for="lifecycleState" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Lifecycle State') }}
                    </label>
                    <select id="lifecycleState" wire:model.live="selectedLifecycleState"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">{{ __('All States') }}</option>
                        @foreach (\App\Models\AmAssetLifecycleState::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->get() as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Action Buttons Section -->
            <div class="flex flex-wrap items-center gap-2">
                <button wire:click="expandAll"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    {{ __('Expand All') }}
                </button>
                <button wire:click="collapseAll"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    {{ __('Collapse All') }}
                </button>
                @if ($search)
                    <button wire:click="debugSearch"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                        Debug: {{ $this->debugSearch() }} matches
                    </button>
                @endif
            </div>
        </div>

        <!-- Debug Info Row -->
        @if ($search)
            <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Search term: <strong>"{{ $search }}"</strong> ({{ strlen($search) }} chars)
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $this->debugSearch() }} matches found
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Tree View -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Asset Hierarchy') }}
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ __('Click on the arrow to expand/collapse asset nodes') }}
            </p>
        </div>

        <div class="p-4">
            @if ($search)
                <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900 rounded-lg">
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        {{ __('Searching for') }}: <strong>"{{ $search }}"</strong>
                        ({{ $this->debugSearch() }} {{ __('matches found') }})
                    </p>
                </div>
            @endif

            @if ($rootAssets->count() > 0)
                <div class="space-y-2">
                    @foreach ($rootAssets as $asset)
                        @include('livewire.partials.asset-tree-node', ['asset' => $asset, 'level' => 0])
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('No assets found') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Try adjusting your search or filter criteria.') }}</p>
                </div>
            @endif
        </div>
    </div>

</div>
