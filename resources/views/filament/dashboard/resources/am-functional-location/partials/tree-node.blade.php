<li class="tree-node">
    <div class="tree-item flex items-center" onclick="toggleNode(this.querySelector('.tree-toggle'))">
        @if($location->childLocations->count() > 0)
            <span class="tree-toggle" onclick="event.stopPropagation(); toggleNode(this);">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </span>
        @else
            <span style="width: 16px;" class="flex items-center justify-center">
                <svg class="w-2 h-2 text-gray-400 dark:text-gray-600" fill="currentColor" viewBox="0 0 8 8">
                    <circle cx="4" cy="4" r="3"/>
                </svg>
            </span>
        @endif
        <div class="location-info flex-grow flex flex-col">
            <span class="location-id">
                {{ $location->functional_location }}
            </span>
            <span class="location-name">
                {{ $location->name }}
            </span>
            @if($location->functionalLocationType)
                <span class="location-type">
                    {{ $location->functionalLocationType->name }}
                </span>
            @endif
        </div>
        <div class="ml-auto flex space-x-2 items-center">
            {{--
            <button 
               onclick="openViewModal({{ $location->id }})"
               class="view-link text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm">
                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View
            </button>
            --}}
            <button 
               onclick="openEditModal({{ $location->id }})"
               class="edit-link text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </button>
        </div>
    </div>
    
    @if($location->childLocations->count() > 0)
        <ul class="tree-children collapsed">
            @foreach($location->childLocations->sortBy('functional_location') as $childLocation)
                @include('filament.dashboard.resources.am-functional-location.partials.tree-node', ['location' => $childLocation])
            @endforeach
        </ul>
    @endif
</li>
