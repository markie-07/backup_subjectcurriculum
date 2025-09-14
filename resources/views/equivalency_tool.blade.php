@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        {{-- Left Panel: Create Equivalency --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg lg:self-start">
            <div class="pb-6">
                <h1 class="text-3xl font-bold text-gray-900">Subject Equivalency Tool</h1>
                <p class="mt-1 text-sm text-gray-500">Map subjects from other schools to your existing subjects.</p>
            </div>
            
            <div class="mt-8 space-y-6">
                <div>
                    <label for="source-subject" class="block text-sm font-medium text-gray-700">Source Subject (from other school)</label>
                    <input type="text" id="source-subject" placeholder="e.g., Programming Fundamentals" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-50 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="equivalent-subject" class="block text-sm font-medium text-gray-700">Equivalent Subject (in this school)</label>
                    <select id="equivalent-subject" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled selected>-- Select an Equivalent Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->subject_code }} - {{ $subject->subject_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-10">
                <button id="create-equivalency-btn" class="w-full bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                    Create Equivalency
                </button>
            </div>
        </div>

        {{-- Right Panel: Existing Equivalencies --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Existing Equivalencies</h2>
            <div class="relative flex items-center mb-6">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="search-equivalency" placeholder="Search by subject name or code..." class="w-full bg-gray-100 border border-gray-300 rounded-lg py-2 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- UPDATE: This list is now dynamically loaded from the database --}}
            <div id="equivalency-list" class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                @forelse ($equivalencies as $item)
                    <div class="equivalency-item p-4 border border-gray-200 rounded-lg flex justify-between items-center" data-id="{{ $item->id }}">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $item->source_subject_name }}</h3>
                            <p class="text-sm text-gray-500">
                                Equivalent to: {{ $item->equivalentSubject->subject_code }} - {{ $item->equivalentSubject->subject_name }}
                            </p>
                        </div>
                        <button class="delete-equivalency-btn text-gray-400 hover:text-red-600 p-1 rounded-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                @empty
                    <p id="no-equivalencies-message" class="text-center text-gray-500 py-4">No equivalencies created yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</main>

{{-- UPDATE: The entire script is updated to handle API calls --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const createBtn = document.getElementById('create-equivalency-btn');
    const sourceSubjectInput = document.getElementById('source-subject');
    const equivalentSubjectSelect = document.getElementById('equivalent-subject');
    const equivalencyList = document.getElementById('equivalency-list');
    const searchInput = document.getElementById('search-equivalency');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Function to add a new equivalency item to the top of the list
    const addEquivalencyToDOM = (equivalency) => {
        const noItemsMessage = document.getElementById('no-equivalencies-message');
        if (noItemsMessage) {
            noItemsMessage.remove();
        }

        const newItem = document.createElement('div');
        newItem.className = 'equivalency-item p-4 border border-gray-200 rounded-lg flex justify-between items-center';
        newItem.dataset.id = equivalency.id;
        newItem.innerHTML = `
            <div>
                <h3 class="font-semibold text-gray-800">${equivalency.source_subject_name}</h3>
                <p class="text-sm text-gray-500">
                    Equivalent to: ${equivalency.equivalent_subject.subject_code} - ${equivalency.equivalent_subject.subject_name}
                </p>
            </div>
            <button class="delete-equivalency-btn text-gray-400 hover:text-red-600 p-1 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        `;
        equivalencyList.prepend(newItem);
    };

    // Handle Create Equivalency button click
    createBtn.addEventListener('click', async function () {
        const sourceSubject = sourceSubjectInput.value.trim();
        const equivalentSubjectId = equivalentSubjectSelect.value;

        if (sourceSubject === '' || equivalentSubjectId === '') {
            alert('Please fill out both subject fields.');
            return;
        }

        try {
            const response = await fetch("{{ route('equivalency_tool.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    source_subject_name: sourceSubject,
                    equivalent_subject_id: equivalentSubjectId
                })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to create equivalency.');
            }

            const newEquivalency = await response.json();
            addEquivalencyToDOM(newEquivalency);

            // Clear input fields for the next entry
            sourceSubjectInput.value = '';
            equivalentSubjectSelect.value = '';

        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred: ' + error.message);
        }
    });

    // Handle Delete Equivalency (using event delegation for dynamic items)
    equivalencyList.addEventListener('click', async function (e) {
        const deleteButton = e.target.closest('.delete-equivalency-btn');
        if (!deleteButton) return;

        const itemToDelete = deleteButton.closest('.equivalency-item');
        const equivalencyId = itemToDelete.dataset.id;

        if (!confirm('Are you sure you want to delete this equivalency?')) {
            return;
        }

        try {
            const response = await fetch(`/equivalencies/${equivalencyId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to delete equivalency.');
            }

            itemToDelete.remove();

            // Show a message if the list becomes empty
            if (equivalencyList.children.length === 0) {
                equivalencyList.innerHTML = '<p id="no-equivalencies-message" class="text-center text-gray-500 py-4">No equivalencies created yet.</p>';
            }

        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred: ' + error.message);
        }
    });

    // Handle Search input
    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value.toLowerCase();
        const items = equivalencyList.getElementsByClassName('equivalency-item');

        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            const textContent = item.textContent.toLowerCase();
            
            if (textContent.includes(searchTerm)) {
                item.style.display = 'flex'; // Use flex to match original style
            } else {
                item.style.display = 'none';
            }
        }
    });
});
</script>
@endsection