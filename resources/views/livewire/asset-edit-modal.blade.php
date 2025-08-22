<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="modal-backdrop">
            <div
                class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ __('Edit Asset') }}: {{ $asset->maintenance_asset ?? '' }}
                        </h3>
                        <button wire:click="closeModal"
                            class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="save">

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                {{ __('Basic Information') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="maintenance_asset"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Asset ID') }}
                                    </label>
                                    <input type="text" id="maintenance_asset" wire:model="maintenance_asset"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('maintenance_asset')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Asset Name') }}
                                    </label>
                                    <input type="text" id="name" wire:model="name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="am_asset_type_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Asset Type') }}
                                    </label>
                                    <select id="am_asset_type_id" wire:model="am_asset_type_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">{{ __('Select Asset Type') }}</option>
                                        @foreach (\App\Models\AmAssetType::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->get() as $type)
                                            <option value="{{ $type->id }}">{{ $type->maintenance_asset_type }} -
                                                {{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('am_asset_type_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="am_asset_lifecycle_state_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Lifecycle State') }}
                                    </label>
                                    <select id="am_asset_lifecycle_state_id" wire:model="am_asset_lifecycle_state_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">{{ __('Select Lifecycle State') }}</option>
                                        @foreach (\App\Models\AmAssetLifecycleState::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->get() as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('am_asset_lifecycle_state_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location & Installation -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                {{ __('Location & Installation') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="am_functional_location_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Functional Location') }}
                                    </label>
                                    <select id="am_functional_location_id" wire:model="am_functional_location_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">{{ __('Select Functional Location') }}</option>
                                        @foreach (\App\Models\AmFunctionalLocation::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->get() as $location)
                                            <option value="{{ $location->id }}">{{ $location->functional_location }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('am_functional_location_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="parent_maintenance_asset_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Parent Asset') }}
                                    </label>
                                    <select id="parent_maintenance_asset_id" wire:model="parent_maintenance_asset_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">{{ __('Select Parent Asset') }}</option>
                                        @foreach (\App\Models\AMAsset::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)->get() as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->maintenance_asset }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_maintenance_asset_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="logistics_location_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Logistics Location') }}
                                    </label>
                                    <input type="text" id="logistics_location_id" wire:model="logistics_location_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('logistics_location_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                {{ __('Financial Information') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="acquisition_cost"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Acquisition Cost') }}
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="acquisition_cost"
                                            wire:model="acquisition_cost"
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    @error('acquisition_cost')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="replacement_value"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Replacement Value') }}
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="replacement_value"
                                            wire:model="replacement_value"
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    @error('replacement_value')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="acquisition_date"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Acquisition Date') }}
                                    </label>
                                    <input type="date" id="acquisition_date" wire:model="acquisition_date"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('acquisition_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="replacement_date"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Replacement Date') }}
                                    </label>
                                    <input type="date" id="replacement_date" wire:model="replacement_date"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('replacement_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Operational Details -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                {{ __('Operational Details') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="active_from"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Active From') }}
                                    </label>
                                    <input type="date" id="active_from" wire:model="active_from"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('active_from')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="active_to"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Active To') }}
                                    </label>
                                    <input type="date" id="active_to" wire:model="active_to"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('active_to')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="model_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Model ID') }}
                                    </label>
                                    <input type="text" id="model_id" wire:model="model_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('model_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="model_year"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Model Year') }}
                                    </label>
                                    <input type="text" id="model_year" wire:model="model_year"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('model_year')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="serial_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Serial Number') }}
                                    </label>
                                    <input type="text" id="serial_id" wire:model="serial_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('serial_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="product_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Product ID') }}
                                    </label>
                                    <input type="text" id="product_id" wire:model="product_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('product_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Warranty & Vendor -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                {{ __('Warranty & Vendor') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="vend_account"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Vendor Account') }}
                                    </label>
                                    <input type="text" id="vend_account" wire:model="vend_account"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('vend_account')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="warranty_date_from_vend"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Warranty Date') }}
                                    </label>
                                    <input type="date" id="warranty_date_from_vend"
                                        wire:model="warranty_date_from_vend"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('warranty_date_from_vend')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="warranty_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Warranty ID') }}
                                    </label>
                                    <input type="text" id="warranty_id" wire:model="warranty_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('warranty_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="purchase_order_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Purchase Order ID') }}
                                    </label>
                                    <input type="text" id="purchase_order_id" wire:model="purchase_order_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('purchase_order_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                {{ __('Additional Information') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="notes"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Notes') }}
                                    </label>
                                    <textarea id="notes" wire:model="notes" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="default_dimension_display_value"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Default Dimension') }}
                                    </label>
                                    <input type="number" step="0.01" id="default_dimension_display_value"
                                        wire:model="default_dimension_display_value"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('default_dimension_display_value')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="fixed_asset_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Fixed Asset ID') }}
                                    </label>
                                    <input type="text" id="fixed_asset_id" wire:model="fixed_asset_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('fixed_asset_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="wrk_ctr_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Work Center ID') }}
                                    </label>
                                    <input type="text" id="wrk_ctr_id" wire:model="wrk_ctr_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('wrk_ctr_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
