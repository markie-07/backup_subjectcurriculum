@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        <div class="bg-white p-8 rounded-2xl shadow-lg lg:self-start">
            <div class="pb-6">
                <h1 class="text-3xl font-bold text-gray-900">Subject Equivalency Tool</h1>
                <p class="mt-1 text-sm text-gray-500">Create and manage new academic curriculums.</p>
            </div>
            
            <div class="mt-8 space-y-6">
                <div>
                    <label for="source-subject" class="block text-sm font-medium text-gray-700">Source Subject</label>
                    <input type="text" id="source-subject" placeholder="e.g., Programming Fundamentals" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-50 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="equivalent-subject" class="block text-sm font-medium text-gray-700">Equivalent Subject</label>
                    <select id="equivalent-subject" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="CS101 - Introduction to Programming">CS101 - Introduction to Programming</option>
                        <option value="MATH101 - College Algebra">MATH101 - College Algebra</option>
                        </select>
                </div>
            </div>

            <div class="mt-10">
                <button id="create-equivalency-btn" class="w-full bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                    Create Equivalency
                </button>
            </div>
        </div>

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

            <div id="equivalency-list" class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                <div class="equivalency-item p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                    <h3 class="font-semibold text-gray-800">Programming Fundamentals</h3>
                    <p class="text-sm text-gray-500">Equivalent to: CS101 - Introduction to Programming</p>
                </div>
                 <div class="equivalency-item p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                    <h3 class="font-semibold text-gray-800">College Mathematics</h3>
                    <p class="text-sm text-gray-500">Equivalent to: MATH101 - College Algebra</p>
                </div>
            </div>
        </div>
    </div>
    </main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const createBtn = document.getElementById('create-equivalency-btn');
    const sourceSubjectInput = document.getElementById('source-subject');
    const equivalentSubjectSelect = document.getElementById('equivalent-subject');
    const equivalencyList = document.getElementById('equivalency-list');
    const searchInput = document.getElementById('search-equivalency');

    // --- Function to Create a New Equivalency ---
    createBtn.addEventListener('click', function () {
        const sourceSubject = sourceSubjectInput.value.trim();
        const equivalentSubject = equivalentSubjectSelect.value;

        if (sourceSubject === '') {
            alert('Please enter a Source Subject.');
            return;
        }

        // Create the new HTML element for the list
        const newItem = document.createElement('div');
        newItem.className = 'equivalency-item p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow';
        newItem.innerHTML = `
            <h3 class="font-semibold text-gray-800">${sourceSubject}</h3>
            <p class="text-sm text-gray-500">Equivalent to: ${equivalentSubject}</p>
        `;

        // Add the new item to the top of the list
        equivalencyList.prepend(newItem);

        // Clear the input field for the next entry
        sourceSubjectInput.value = '';
    });

    // --- Function for Live Search ---
    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value.toLowerCase();
        const items = equivalencyList.getElementsByClassName('equivalency-item');

        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            const textContent = item.textContent.toLowerCase();
            
            if (textContent.includes(searchTerm)) {
                item.style.display = 'block'; // Show the item
            } else {
                item.style.display = 'none'; // Hide the item
            }
        }
    });
});
</script>

@endsection