<div class="space-y-6">
    <!-- Header Information -->
    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Functional Location ID</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">{{ $record->functional_location }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                <dd class="mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $record->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                        {{ $record->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </dd>
            </div>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->description ?: 'N/A' }}</dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $record->functionalLocationType?->name ?: 'N/A' }}
                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lifecycle State</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $record->functionalLocationLifecycleState?->name ?: 'N/A' }}
                </dd>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Parent Location</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    @if($record->parentLocation)
                        {{ $record->parentLocation->functional_location }} - {{ $record->parentLocation->description }}
                    @else
                        Root Location
                    @endif
                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Child Locations</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $record->childLocations->count() }} child location(s)
                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Installation Date</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $record->installation_date ? $record->installation_date->format('M d, Y') : 'N/A' }}
                </dd>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    @if($record->superior_functional_location || $record->work_center || $record->company_code)
    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Additional Information</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if($record->superior_functional_location)
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Superior FL</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->superior_functional_location }}</dd>
            </div>
            @endif

            @if($record->work_center)
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Work Center</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->work_center }}</dd>
            </div>
            @endif

            @if($record->company_code)
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Company Code</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->company_code }}</dd>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Child Locations -->
    @if($record->childLocations->count() > 0)
    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Direct Child Locations</h4>
        <div class="space-y-2">
            @foreach($record->childLocations as $child)
            <div class="flex items-center justify-between p-2 bg-white dark:bg-gray-600 rounded border">
                <div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $child->functional_location }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">{{ $child->description }}</span>
                </div>
                <button 
                    onclick="closeViewModal(); openViewModal({{ $child->id }})"
                    class="text-blue-600 hover:text-blue-800 text-xs">
                    View
                </button>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
        <button 
            onclick="closeViewModal()"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500">
            Close
        </button>
    </div>
    <!-- Action Button -->
    <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-600">
        <button 
            onclick="closeViewModal()"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500">
            Close
        </button>
    </div>
</div>
