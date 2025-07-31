<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">{{ __('Settings Overview') }}</h2>
            <p class="text-gray-600 dark:text-gray-300">{{ __('Manage your organization settings, configure functional locations, and set up asset management parameters.') }}</p>
        </div>

        <!-- Settings Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Functional Locations Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md dark:hover:shadow-lg transition-shadow p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                        <x-heroicon-o-map-pin class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-white">{{ __('Functional Locations') }}</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ __('Manage lifecycle states and permissions for functional locations in your organization.') }}</p>
                <div class="space-y-2">
                    <a href="{{ \App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                        <x-heroicon-m-arrow-path class="w-4 h-4 mr-1" />
                        {{ __('Lifecycle States') }}
                    </a>
                    <br>
                    <a href="{{ \App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                        <x-heroicon-m-cube-transparent class="w-4 h-4 mr-1" />
                        {{ __('Lifecycle Models') }}
                    </a>
                    <br>
                    <a href="{{ \App\Filament\Dashboard\Resources\AmFunctionalLocationTypeResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                        <x-heroicon-m-building-office class="w-4 h-4 mr-1" />
                        {{ __('Location Types') }}
                    </a>
                    <br>
                    <a href="{{ \App\Filament\Dashboard\Resources\AmFunctionalLocationResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                        <x-heroicon-m-map-pin class="w-4 h-4 mr-1" />
                        {{ __('Functional Locations') }}
                    </a>
                </div>
            </div>

            <!-- Assets Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md dark:hover:shadow-lg transition-shadow p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                        <x-heroicon-o-cube class="w-6 h-6 text-green-600 dark:text-green-400" />
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-white">{{ __('Assets') }}</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ __('Configure asset lifecycle states, maintenance schedules, and asset management parameters.') }}</p>
                <div class="space-y-2">
                    <a href="{{ \App\Filament\Dashboard\Resources\AmAssetLifecycleStateResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-500 dark:hover:text-green-300">
                        <x-heroicon-m-arrow-path class="w-4 h-4 mr-1" />
                        {{ __('Lifecycle States') }}
                    </a>
                    <br>
                    <a href="{{ \App\Filament\Dashboard\Resources\AmAssetLifecycleModelResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-500 dark:hover:text-green-300">
                        <x-heroicon-m-cog-6-tooth class="w-4 h-4 mr-1" />
                        {{ __('Asset Lifecycle Models') }}
                    </a>
                    <br>
                    <a href="{{ \App\Filament\Dashboard\Resources\AmAssetTypeResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-500 dark:hover:text-green-300">
                        <x-heroicon-m-cube class="w-4 h-4 mr-1" />
                        {{ __('Asset Types') }}
                    </a>
                </div>
            </div>

            <!-- General Settings Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md dark:hover:shadow-lg transition-shadow p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                        <x-heroicon-o-cog-6-tooth class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-white">{{ __('General') }}</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ __('Configure general organization settings, user preferences, and system parameters.') }}</p>
                <div class="space-y-2">
                    <span class="inline-flex items-center text-sm font-medium text-gray-400 dark:text-gray-500">
                        <x-heroicon-m-adjustments-horizontal class="w-4 h-4 mr-1" />
                        {{ __('System Settings') }} <span class="ml-1 text-xs">({{ __('Coming Soon') }})</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Quick Actions') }}</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ \App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Functional Location State') }}
                </a>
                <a href="{{ \App\Filament\Dashboard\Resources\AmAssetLifecycleStateResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-500 text-white text-sm font-medium rounded-md hover:bg-green-700 dark:hover:bg-green-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Asset Lifecycle State') }}
                </a>
                <a href="{{ \App\Filament\Dashboard\Resources\AmAssetTypeResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 dark:bg-purple-500 text-white text-sm font-medium rounded-md hover:bg-purple-700 dark:hover:bg-purple-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Asset Type') }}
                </a>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-arrow-path class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Functional Location States') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AmFunctionalLocationLifecycleState::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-arrow-path class="w-8 h-8 text-green-600 dark:text-green-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Asset Lifecycle States') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AmAssetLifecycleState::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-cube class="w-8 h-8 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Asset Types') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AmAssetType::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-check-circle class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Active Functional Locations') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AmFunctionalLocationLifecycleState::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->where('functional_location_active', true)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-check-circle class="w-8 h-8 text-green-600 dark:text-green-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Active Assets') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AmAssetLifecycleState::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->where('asset_active', true)->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
