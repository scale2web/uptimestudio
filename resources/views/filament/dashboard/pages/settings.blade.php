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
                    {{-- <a href="{{ \App\Filament\Dashboard\Resources\AmFunctionalLocationResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                        <x-heroicon-m-map-pin class="w-4 h-4 mr-1" />
                        {{ __('Functional Locations') }}
                    </a> --}}
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

            <!-- Jobs Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md dark:hover:shadow-lg transition-shadow p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 dark:bg-orange-900/30 p-3 rounded-lg">
                        <x-heroicon-o-wrench-screwdriver class="w-6 h-6 text-orange-600 dark:text-orange-400" />
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-white">{{ __('Jobs') }}</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ __('Configure maintenance job types, categories, and work order parameters.') }}</p>
                            <div class="space-y-2">
                <a href="{{ \App\Filament\Dashboard\Resources\AMMaintenanceJobTypeResource::getUrl('index') }}" 
                   class="inline-flex items-center text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300">
                    <x-heroicon-m-wrench-screwdriver class="w-4 h-4 mr-1" />
                    {{ __('Job Types') }}
                </a>
                <br>
                <a href="{{ \App\Filament\Dashboard\Resources\AMMaintenanceJobTypeCategoryResource::getUrl('index') }}" 
                   class="inline-flex items-center text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300">
                    <x-heroicon-m-rectangle-stack class="w-4 h-4 mr-1" />
                    {{ __('Job Type Categories') }}
                </a>
                <br>
                <a href="{{ \App\Filament\Dashboard\Resources\AmWorkOrderLifecycleModelResource::getUrl('index') }}" 
                   class="inline-flex items-center text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300">
                    <x-heroicon-m-cog-6-tooth class="w-4 h-4 mr-1" />
                    {{ __('Work Order Lifecycle Models') }}
                </a>
                <br>
                <a href="{{ \App\Filament\Dashboard\Resources\AmWorkOrderLifecycleStateResource::getUrl('index') }}" 
                   class="inline-flex items-center text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300">
                    <x-heroicon-m-list-bullet class="w-4 h-4 mr-1" />
                    {{ __('Work Order Lifecycle States') }}
                </a>
                <br>
                <a href="{{ \App\Filament\Dashboard\Resources\AMCostTypeResource::getUrl('index') }}" 
                   class="inline-flex items-center text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300">
                    <x-heroicon-m-currency-dollar class="w-4 h-4 mr-1" />
                    {{ __('Cost Types') }}
                </a>
                <br>
                <a href="{{ \App\Filament\Dashboard\Resources\AMWorkOrderTypeResource::getUrl('index') }}" 
                   class="inline-flex items-center text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300">
                    <x-heroicon-m-wrench-screwdriver class="w-4 h-4 mr-1" />
                    {{ __('Work Order Types') }}
                </a>
            </div>
            </div>

            <!-- Maintenance Requests Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md dark:hover:shadow-lg transition-shadow p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 dark:bg-indigo-900/30 p-3 rounded-lg">
                        <x-heroicon-o-wrench class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-white">{{ __('Maintenance Requests') }}</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ __('Configure maintenance request lifecycle states and permissions for your organization.') }}</p>
                <div class="space-y-2">
                    <a href="{{ \App\Filament\Dashboard\Resources\AmMaintenanceLifecycleStateResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                        <x-heroicon-m-arrow-path class="w-4 h-4 mr-1" />
                        {{ __('Lifecycle States') }}
                    </a>
                </div>
            </div>

            <!-- Work Orders Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md dark:hover:shadow-lg transition-shadow p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-red-100 dark:bg-red-900/30 p-3 rounded-lg">
                        <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-600 dark:text-red-400" />
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-white">{{ __('Work Orders') }}</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ __('Configure work order criticality levels and risk assessment parameters.') }}</p>
                <div class="space-y-2">
                    <a href="{{ \App\Filament\Dashboard\Resources\AMCriticalityResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300">
                        <x-heroicon-m-exclamation-triangle class="w-4 h-4 mr-1" />
                        {{ __('Criticality Levels') }}
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
                    <a href="{{ \App\Filament\Dashboard\Resources\AMWorkerResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300">
                        <x-heroicon-m-users class="w-4 h-4 mr-1" />
                        {{ __('Workers') }}
                    </a>
                    <br>
                    <a href="{{ \App\Filament\Dashboard\Resources\AMWorkerGroupResource::getUrl('index') }}" 
                       class="inline-flex items-center text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300">
                        <x-heroicon-m-user-group class="w-4 h-4 mr-1" />
                        {{ __('Worker Groups') }}
                    </a>
                    <br>
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
                <a href="{{ \App\Filament\Dashboard\Resources\AMMaintenanceJobTypeCategoryResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-orange-600 dark:bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-700 dark:hover:bg-orange-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Job Type Category') }}
                </a>
                <a href="{{ \App\Filament\Dashboard\Resources\AMMaintenanceJobTypeResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-orange-600 dark:bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-700 dark:hover:bg-orange-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Job Type') }}
                </a>
                <a href="{{ \App\Filament\Dashboard\Resources\AmWorkOrderLifecycleModelResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-orange-600 dark:bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-700 dark:hover:bg-orange-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Work Order Lifecycle Model') }}
                </a>
                <a href="{{ \App\Filament\Dashboard\Resources\AmWorkOrderLifecycleStateResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-orange-600 dark:bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-700 dark:hover:bg-orange-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Work Order Lifecycle State') }}
                </a>
                <a href="{{ \App\Filament\Dashboard\Resources\AMCostTypeResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-orange-600 dark:bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-700 dark:hover:bg-orange-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Cost Type') }}
                </a>
                <a href="{{ \App\Filament\Dashboard\Resources\AMCriticalityResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-600 dark:bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-700 dark:hover:bg-red-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Criticality Level') }}
                </a>
                <a href="{{ \App\Filament\Dashboard\Resources\AMWorkerResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 dark:bg-purple-500 text-white text-sm font-medium rounded-md hover:bg-purple-700 dark:hover:bg-purple-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Worker') }}
                </a>
                <a href="{{ \App\Filament\Dashboard\Resources\AMWorkerGroupResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 dark:bg-purple-500 text-white text-sm font-medium rounded-md hover:bg-purple-700 dark:hover:bg-purple-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Worker Group') }}
                </a>
                <a href="{{ \App\Filament\Dashboard\Resources\AmMaintenanceLifecycleStateResource::getUrl('create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 text-white text-sm font-medium rounded-md hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors">
                    <x-heroicon-m-plus class="w-4 h-4 mr-2" />
                    {{ __('Add Maintenance Lifecycle State') }}
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
                        <x-heroicon-o-wrench class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Maintenance Lifecycle States') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AmMaintenanceLifecycleState::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
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

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-rectangle-stack class="w-8 h-8 text-orange-600 dark:text-orange-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Job Type Categories') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AMMaintenanceJobTypeCategory::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-wrench-screwdriver class="w-8 h-8 text-orange-600 dark:text-orange-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Job Types') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AMMaintenanceJobType::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-cog-6-tooth class="w-8 h-8 text-orange-600 dark:text-orange-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Work Order Lifecycle Models') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AmWorkOrderLifecycleModel::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-list-bullet class="w-8 h-8 text-orange-600 dark:text-orange-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Work Order Lifecycle States') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AmWorkOrderLifecycleState::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-currency-dollar class="w-8 h-8 text-orange-600 dark:text-orange-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Cost Types') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AMCostType::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-exclamation-triangle class="w-8 h-8 text-red-600 dark:text-red-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Criticality Levels') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AMCriticality::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-users class="w-8 h-8 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Workers') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AMWorker::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-user-group class="w-8 h-8 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Worker Groups') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ \App\Models\AMWorkerGroup::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
