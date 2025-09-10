@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    <div class="container mx-auto">
        {{-- Main Content Section --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Subject Offering History</h1>
            </div>
        </div>

        {{-- Main container for the design --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            {{-- Curriculum and Search Bar --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b border-gray-200 mb-4 space-y-4 md:space-y-0">
                <div class="flex-1 w-full md:w-auto">
                    <select class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option>BSIT - Bachelor of Science and Information Technology</option>
                        <option>BSCS - Bachelor of Science in Computer Science</option>
                    </select>
                </div>
                <div class="relative flex-1 w-full md:w-auto md:ml-4">
                    {{-- MODIFIED: Added an ID for the search input --}}
                    <input type="text" id="searchInput" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Search by subject, code, year...">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            {{-- Main table for subject offerings --}}
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-800 rounded-t-lg">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider rounded-tl-lg">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Academic Year</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Semester</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Subjects</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Subject Code</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Unit</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider rounded-tr-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subjectTableBody" class="bg-white divide-y divide-gray-200">
                        {{-- Sample data based on the image --}}
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">2</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">2020-2021</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">1st semester</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Intro to Programming</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">ITC 101</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">3</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                <span class="text-gray-400">|</span>
                                <a href="#" class="text-green-600 hover:underline">Export</a>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">1</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">2019-2020</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">1st semester</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Intro to computing</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">COMP 101</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">3</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                <span class="text-gray-400">|</span>
                                <a href="#" class="text-green-600 hover:underline">Export</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

{{-- NEW: Added script for search functionality --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('subjectTableBody');
    const tableRows = tableBody.getElementsByTagName('tr');

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();

        for (let i = 0; i < tableRows.length; i++) {
            const row = tableRows[i];
            const rowText = row.textContent.toLowerCase();

            if (rowText.includes(searchTerm)) {
                row.style.display = ''; // Show the row
            } else {
                row.style.display = 'none'; // Hide the row
            }
        }
    });
});
</script>

@endsection