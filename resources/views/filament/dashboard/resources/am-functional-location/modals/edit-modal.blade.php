<div class="space-y-6">
    <form id="editForm">
        @csrf
        <!-- Basic Information Section -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Basic Information</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="functional_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Functional Location ID *
                    </label>
                    <input 
                        type="text" 
                        id="functional_location" 
                        name="functional_location" 
                        value="{{ $record->functional_location }}" 
                        required
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Description
                    </label>
                    <input 
                        type="text" 
                        id="description" 
                        name="description" 
                        value="{{ $record->description }}"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="is_active" class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="is_active" 
                            name="is_active" 
                            value="1"
                            {{ $record->is_active ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                </div>

                <div>
                    <label for="installation_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Installation Date
                    </label>
                    <input 
                        type="date" 
                        id="installation_date" 
                        name="installation_date" 
                        value="{{ $record->installation_date ? $record->installation_date->format('Y-m-d') : '' }}"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Hierarchy Section -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Hierarchy</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="am_parent_functional_location_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Parent Functional Location
                    </label>
                    <select 
                        id="am_parent_functional_location_id" 
                        name="am_parent_functional_location_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Root Location --</option>
                        @foreach(\App\Models\AmFunctionalLocation::where('id', '!=', $record->id)->orderBy('functional_location')->get() as $location)
                            <option value="{{ $location->id }}" {{ $record->am_parent_functional_location_id == $location->id ? 'selected' : '' }}>
                                {{ $location->functional_location }} - {{ $location->description }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="superior_functional_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Superior Functional Location
                    </label>
                    <input 
                        type="text" 
                        id="superior_functional_location" 
                        name="superior_functional_location" 
                        value="{{ $record->superior_functional_location }}"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Classification Section -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Classification</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="am_functional_location_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Type
                    </label>
                    <select 
                        id="am_functional_location_type_id" 
                        name="am_functional_location_type_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Select Type --</option>
                        @foreach(\App\Models\AmFunctionalLocationType::orderBy('name')->get() as $type)
                            <option value="{{ $type->id }}" {{ $record->am_functional_location_type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="am_functional_location_lifecycle_state_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Lifecycle State
                    </label>
                    <select 
                        id="am_functional_location_lifecycle_state_id" 
                        name="am_functional_location_lifecycle_state_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Select State --</option>
                        @foreach(\App\Models\AmFunctionalLocationLifecycleState::orderBy('name')->get() as $state)
                            <option value="{{ $state->id }}" {{ $record->am_functional_location_lifecycle_state_id == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Organization Section -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Organization</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="work_center" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Work Center
                    </label>
                    <input 
                        type="text" 
                        id="work_center" 
                        name="work_center" 
                        value="{{ $record->work_center }}"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="company_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Company Code
                    </label>
                    <input 
                        type="text" 
                        id="company_code" 
                        name="company_code" 
                        value="{{ $record->company_code }}"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
            <button 
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Changes
            </button>
            <button 
                type="button"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500">
                Cancel
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const locationId = {{ $record->id }};
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>Saving...';
    submitBtn.disabled = true;

    fetch(`/dashboard/am-functional-locations/${locationId}/update-modal`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(async response => {
        let data;
        try {
            data = await response.json();
        } catch (e) {
            data = { success: false, message: 'Unexpected response' };
        }
        // Always keep modal open after save
        window.keepEditModalOpen = true;

        if (data.success) {
            let successMsg = document.getElementById('edit-success-message');
            if (!successMsg) {
                successMsg = document.createElement('div');
                successMsg.id = 'edit-success-message';
                successMsg.className = 'mb-4 p-3 rounded bg-green-100 text-green-800 text-sm font-medium border border-green-300';
                this.prepend(successMsg);
            }
            successMsg.textContent = data.message || 'Update successful';
        } else {
            alert('Error: ' + (data.message || 'Failed to update functional location'));
        }
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    })
    .catch(error => {
        alert('Error updating functional location');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        // Always keep modal open even on error
        window.keepEditModalOpen = true;
    });
});
</script>
