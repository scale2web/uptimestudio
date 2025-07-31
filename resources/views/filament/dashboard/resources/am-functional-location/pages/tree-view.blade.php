<x-filament-panels::page>
    <div>
        <div class="space-y-6">
            <!-- Tree Structure Display -->
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Functional Locations Hierarchy
                </h2>
                <div class="flex space-x-2">
                    <button 
                        onclick="expandAll()" 
                        class="expand-collapse-btn inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600"
                    >
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Expand All
                    </button>
                    <button 
                        onclick="collapseAll()" 
                        class="expand-collapse-btn inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600"
                    >
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                        </svg>
                        Collapse All
                    </button>
                </div>
            </div>

            <div class="tree-container">
                @if($rootLocations->count() > 0)
                    <ul class="tree-root">
                        @foreach($rootLocations as $location)
                            @include('filament.dashboard.resources.am-functional-location.partials.tree-node', ['location' => $location])
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No functional locations</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new functional location.</p>
                    </div>
                @endif
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-md bg-indigo-500 text-white">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Locations</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $rootLocations->sum(fn($loc) => $this->countLocations($loc)) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-md bg-green-500 text-white">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Root Locations</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $rootLocations->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-md bg-yellow-500 text-white">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Max Depth</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $rootLocations->max(fn($loc) => $this->maxDepth($loc)) + 1 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-md bg-purple-500 text-white">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Leaf Nodes</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $rootLocations->sum(fn($loc) => $this->countLeafNodes($loc)) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="view-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeViewModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-middle bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="view-modal-title">
                            View Functional Location
                        </h3>
                        <button type="button" onclick="closeViewModal()" class="bg-white dark:bg-gray-800 rounded-md text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div id="viewModalContent" class="max-h-[70vh] overflow-auto">
                        <!-- Content will be loaded here -->
                        <div class="text-center text-gray-500" id="viewModalEmpty">No data loaded.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="edit-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay for edit modal -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                 aria-hidden="true"
                 onclick="if(!window.keepEditModalOpen) closeEditModal();"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="edit-modal-title">
                            Edit Functional Location
                        </h3>
                        <!-- Close button for edit modal -->
                        <button type="button"
                                onclick="if(!window.keepEditModalOpen) closeEditModal();"
                                class="bg-white dark:bg-gray-800 rounded-md text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div id="editModalContent">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tree-container {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        .tree-root {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .tree-node {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .tree-toggle:hover {
            background-color: #d1d5db;
            border-color: #9ca3af;
        }

        .dark .tree-toggle {
            background-color: #374151;
            color: #d1d5db;
            border-color: #4b5563;
        }

        .dark .tree-toggle:hover {
            background-color: #4b5563;
            border-color: #6b7280;
            color: #f3f4f6;
        }

        .tree-children {
            margin-left: 1.5rem; /* 24px */
            border-left: 1px dashed #d1d5db;
            padding-left: 0.75rem; /* 12px */
        }

        .dark .tree-children {
            border-left-color: #4b5563;
        }

        .tree-children.collapsed {
            display: none;
        }

        .location-info {
            display: flex;
            flex-direction: column;
            gap: 0.125rem; /* 2px */
            flex-grow: 1;
            min-width: 0; /* Allow text truncation */
        }

        .location-id {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.875rem; /* 14px */
            line-height: 1.25rem;
        }

        .dark .location-id {
            color: #f3f4f6;
        }

        .location-name {
            font-size: 0.8125rem; /* 13px */
            line-height: 1.125rem;
            color: #6b7280;
            font-weight: 400;
        }

        .dark .location-name {
            color: #9ca3af;
        }

        .location-type {
            font-size: 0.75rem; /* 12px */
            line-height: 1rem;
            background-color: #f3f4f6;
            color: #374151;
            padding: 0.125rem 0.5rem; /* 2px 8px */
            border-radius: 0.75rem; /* 12px */
            display: inline-block;
            border: 1px solid #e5e7eb;
            margin-top: 0.125rem; /* 2px */
            max-width: fit-content;
            font-weight: 500;
        }

        .dark .location-type {
            background-color: #374151;
            color: #d1d5db;
            border-color: #4b5563;
        }

        /* Action links styling */
        .tree-item a {
            padding: 0.25rem 0.5rem; /* 4px 8px */
            border-radius: 0.25rem; /* 4px */
            text-decoration: none;
            font-size: 0.75rem; /* 12px */
            line-height: 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem; /* 4px */
        }

        .tree-item a:hover {
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dark .tree-item a:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* View link */
        .tree-item a.view-link {
            background-color: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.2);
        }

        .tree-item a.view-link:hover {
            background-color: rgba(34, 197, 94, 0.2);
            border-color: rgba(34, 197, 94, 0.3);
        }

        .dark .tree-item a.view-link {
            background-color: rgba(34, 197, 94, 0.2);
            border-color: rgba(34, 197, 94, 0.3);
        }

        .dark .tree-item a.view-link:hover {
            background-color: rgba(34, 197, 94, 0.3);
            border-color: rgba(34, 197, 94, 0.4);
        }

        /* Edit link */
        .tree-item a.edit-link {
            background-color: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
        }

        .tree-item a.edit-link:hover {
            background-color: rgba(59, 130, 246, 0.2);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .dark .tree-item a.edit-link {
            background-color: rgba(59, 130, 246, 0.2);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .dark .tree-item a.edit-link:hover {
            background-color: rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.4);
        }

        /* Expand/Collapse buttons */
        .expand-collapse-btn {
            transition: all 0.2s ease;
            border: 1px solid #d1d5db !important;
        }

        .expand-collapse-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dark .expand-collapse-btn {
            background-color: #374151 !important;
            border-color: #4b5563 !important;
            color: #f3f4f6 !important;
        }

        .dark .expand-collapse-btn:hover {
            background-color: #4b5563 !important;
            border-color: #6b7280 !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
    </style>

    <script>
        function expandAll() {
            document.querySelectorAll('.tree-children').forEach(el => {
                el.classList.remove('collapsed');
            });
            document.querySelectorAll('.tree-toggle svg').forEach(el => {
                el.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>';
            });
        }

        function collapseAll() {
            document.querySelectorAll('.tree-children').forEach(el => {
                el.classList.add('collapsed');
            });
            document.querySelectorAll('.tree-toggle svg').forEach(el => {
                el.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
            });
        }

        function toggleNode(button) {
            const children = button.closest('.tree-item').nextElementSibling;
            const svg = button.querySelector('svg');
            
            if (children && children.classList.contains('tree-children')) {
                children.classList.toggle('collapsed');
                
                if (children.classList.contains('collapsed')) {
                    svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
                } else {
                    svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>';
                }
            }
        }

        // Initialize collapsed state
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.tree-children').forEach(el => {
                el.classList.add('collapsed');
            });
            document.querySelectorAll('.tree-toggle svg').forEach(el => {
                el.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
            });
        });

        // Modal functions
        function openViewModal(locationId) {
            const modal = document.getElementById('viewModal');
            const content = document.getElementById('viewModalContent');
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Load content
            content.innerHTML = '<div class="flex justify-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div></div>';
            
            // Fetch the view content
            fetch(`/dashboard/am-functional-locations/${locationId}/view-modal`)
                .then(response => response.text())
                .then(html => {
                    // Remove default message before injecting new HTML
                    const emptyMsg = document.getElementById('viewModalEmpty');
                    if (emptyMsg) emptyMsg.remove();
                    console.log('View Modal HTML:', html);
                    content.innerHTML = html;
                })
                .catch(error => {
                    content.innerHTML = '<div class="text-red-600">Error loading content</div>';
                });
        }

        function closeViewModal() {

        // Helper to attach submit handler to the edit modal form
        function attachEditModalFormHandler(content) {
            const form = content.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Intercept AJAX submit
                    setTimeout(function() {
                        // After AJAX completes and content is replaced, set flag and re-attach handler
                        window.keepEditModalOpen = true;
                        // Re-attach handler to new form if present
                        attachEditModalFormHandler(content);
                    }, 500);
                });
            }
        }
            document.getElementById('viewModal').classList.add('hidden');
        }

        function openEditModal(locationId) {
            const modal = document.getElementById('editModal');
            const content = document.getElementById('editModalContent');
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Load content
            content.innerHTML = '<div class="flex justify-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div></div>';
            
            // Fetch the edit form content
            window.keepEditModalOpen = true;
            fetch(`/dashboard/am-functional-locations/${locationId}/edit-modal`)
                .then(response => response.text())
                .then(html => {
                    console.log('Edit Modal HTML:', html);
                    content.innerHTML = html;
                    // Ensure keepEditModalOpen is always true after content loads
                    window.keepEditModalOpen = true;
                    // Patch: If the loaded content contains a form, patch its submit handler
                    const form = content.querySelector('form');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            // If AJAX submit, set keepEditModalOpen to true after success
                            setTimeout(function() {
                                window.keepEditModalOpen = true;
                            }, 500); // Delay to allow AJAX to complete
                        });
                    }
                })
                .catch(error => {
                    content.innerHTML = '<div class="text-red-600">Error loading content</div>';
                });
        }

        function closeEditModal() {
            // Only close if keepEditModalOpen is NOT true
            if (window.keepEditModalOpen) {
                // Prevent closing
                return;
            }
            document.getElementById('editModal').classList.add('hidden');
        }

        // Make sure all triggers use this function!
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                if (!window.keepEditModalOpen) closeEditModal();
            }
        });

        // If you have a background overlay that closes the modal, update its onclick:
        document.querySelectorAll('.modal-background').forEach(bg => {
            bg.onclick = function() {
                if (!window.keepEditModalOpen) closeEditModal();
            }
        });
    </script>
</div>
</x-filament-panels::page>
