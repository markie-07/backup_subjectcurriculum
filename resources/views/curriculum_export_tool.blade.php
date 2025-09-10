@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
                <!-- Main Content Start -->
                 <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 bg-white p-8 rounded-2xl shadow-lg">
                        <div class="pb-6 border-b border-gray-200">
                            <h1 class="text-3xl font-bold text-gray-900">Curriculum Export Tool</h1>
                            <p class="mt-1 text-sm text-gray-500">Export curriculum data in various formats</p>
                        </div>
                        
                        <div class="mt-8">
                            <h2 class="text-xl font-semibold text-gray-800">Export Configuration</h2>
                            <div class="space-y-6 mt-4">
                                <div>
                                    <label for="curriculum-select" class="block text-sm font-medium text-gray-700">Select Curriculum</label>
                                    <select id="curriculum-select" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option>BSIT - Bachelor of Science and Information Technology</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Export Format</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input id="pdf-doc" name="export-format" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <label for="pdf-doc" class="ml-3 block text-sm font-medium text-gray-700">PDF Document</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                    <input type="text" id="date" value="August 14 2025" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                            <button class="w-full bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                                Export Curriculum
                            </button>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b">Export History</h2>
                        <div class="space-y-4 max-h-[60vh] overflow-y-auto">
                            <!-- History Item -->
                            <div class="flex items-center justify-between p-4 border rounded-lg hover:shadow-md transition-shadow">
                                <div>
                                    <h3 class="font-semibold text-gray-800">BS Computer Science - Complete</h3>
                                    <p class="text-sm text-gray-500">PDF Format • Generated: August 14, 2024</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <button class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></button>
                                    <button class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></button>
                                </div>
                            </div>
                             <!-- Repeat History Item for demo -->
                            <div class="flex items-center justify-between p-4 border rounded-lg hover:shadow-md transition-shadow">
                                <div>
                                    <h3 class="font-semibold text-gray-800">BS Computer Science - Complete</h3>
                                    <p class="text-sm text-gray-500">PDF Format • Generated: August 14, 2024</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <button class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></button>
                                    <button class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-4 border rounded-lg hover:shadow-md transition-shadow">
                                <div>
                                    <h3 class="font-semibold text-gray-800">BS Computer Science - Complete</h3>
                                    <p class="text-sm text-gray-500">PDF Format • Generated: August 14, 2024</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <button class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></button>
                                    <button class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main Content End -->
            </main>
@endsection