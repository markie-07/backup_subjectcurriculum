@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    <div class="container mx-auto">
        {{-- Main Content Section --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Subject History</h1>
            </div>
        </div>

        {{-- Main container for the design --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            {{-- Curriculum and Search Bar --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b border-gray-200 mb-4 space-y-4 md:space-y-0">
                <div class="flex-1 w-full md:w-auto">
                    {{-- This dropdown is for filtering and should be populated dynamically --}}
                    <select id="curriculumFilter" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="All">All Curriculums</option>
                        {{-- Options will be populated by JavaScript from API call --}}
                    </select>
                </div>
                <div class="relative flex-1 w-full md:w-auto md:ml-4">
                    <input type="text" id="searchInput" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Search by subject code, name, year...">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            {{-- Table for Subjects --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider rounded-tl-lg">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Academic Year</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Curriculum</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Subject Code</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Action</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider rounded-tr-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subjectTableBody" class="bg-white divide-y divide-gray-200">
                        @forelse($history as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{-- $record->academic_year_range --}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{-- $record->curriculum->name --}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{-- $record->subject_code --}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{-- ucfirst($record->action) --}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{-- $record->created_at->format('Y-m-d H:i:s') --}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                <span class="text-gray-400">|</span>
                                <a href="#" class="text-green-600 hover:underline">Export</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                No history records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

{{-- Script to handle filtering and searching --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const curriculumFilter = document.getElementById('curriculumFilter');
        const tableBody = document.getElementById('subjectTableBody');
        const tableRows = tableBody.getElementsByTagName('tr');

        const filterTable = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCurriculum = curriculumFilter.value;

            for (let i = 0; i < tableRows.length; i++) {
                const row = tableRows[i];
                const rowCells = row.getElementsByTagName('td');
                const academicYear = rowCells[1].textContent.toLowerCase();
                const curriculumName = rowCells[2].textContent.toLowerCase();
                const subjectCode = rowCells[3].textContent.toLowerCase();
                const action = rowCells[4].textContent.toLowerCase();

                const matchesSearch = (academicYear.includes(searchTerm) || curriculumName.includes(searchTerm) || subjectCode.includes(searchTerm) || action.includes(searchTerm));
                const matchesFilter = (selectedCurriculum === 'All' || curriculumName.includes(selectedCurriculum.toLowerCase()));

                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        };

        searchInput.addEventListener('input', filterTable);
        curriculumFilter.addEventListener('change', filterTable);

        // Fetch curriculums to populate the filter dropdown
        const fetchCurriculums = async () => {
            try {
                const response = await fetch('/api/curriculums');
                const curriculums = await response.json();
                curriculums.forEach(curriculum => {
                    const option = document.createElement('option');
                    option.value = curriculum.name;
                    option.textContent = curriculum.name;
                    curriculumFilter.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching curriculums:', error);
            }
        };

        fetchCurriculums();
    });
</script>
@endsection