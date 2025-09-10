@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    <div class="container mx-auto">
        <div class="bg-white p-6 rounded-2xl shadow-lg mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Subject History</h1>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Academic Year</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Subject Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Subject Code</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Year</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Semester</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Date Removed</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subjectTableBody" class="bg-white divide-y divide-gray-200">
                        @forelse($history as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $record->academic_year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $record->subject_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $record->subject_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $record->year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $record->semester == 1 ? '1st Semester' : '2nd Semester' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $record->created_at->format('n/j/y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                <span>|</span>
                                <a href="#" class="text-green-600 hover:underline">Export</a>
                                <span>|</span>
                                <button class="text-purple-600 hover:underline retrieve-btn" data-id="{{ $record->id }}">Retrieve</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
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

{{-- Modal for Retrieve Confirmation --}}
<div id="retrieveConfirmationModal" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-75 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-purple-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M7 7l9 9M20 20v-5h-5"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Retrieve Subject</h3>
            <p class="text-sm text-gray-500 mt-2">Are you sure you want to add this subject back to the curriculum?</p>
            <div class="mt-6 flex justify-center gap-4">
                <button id="cancelRetrieveButton" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
                <button id="confirmRetrieveButton" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">Yes, Retrieve</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const retrieveModal = document.getElementById('retrieveConfirmationModal');
        const cancelRetrieveButton = document.getElementById('cancelRetrieveButton');
        const confirmRetrieveButton = document.getElementById('confirmRetrieveButton');
        let historyIdToRetrieve = null;

        document.querySelectorAll('.retrieve-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                historyIdToRetrieve = e.target.dataset.id;
                retrieveModal.classList.remove('hidden');
            });
        });

        const hideRetrieveModal = () => {
            retrieveModal.classList.add('hidden');
            historyIdToRetrieve = null;
        };

        cancelRetrieveButton.addEventListener('click', hideRetrieveModal);
        retrieveModal.addEventListener('click', (e) => {
            if (e.target === retrieveModal) {
                hideRetrieveModal();
            }
        });

        confirmRetrieveButton.addEventListener('click', async () => {
            if (!historyIdToRetrieve) return;

            try {
                const response = await fetch(`/subject_history/${historyIdToRetrieve}/retrieve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Failed to retrieve the subject.');
                }
                
                alert('Subject retrieved successfully!');
                window.location.reload();

            } catch (error) {
                console.error('Error retrieving subject:', error);
                alert('Error: ' + error.message);
            } finally {
                hideRetrieveModal();
            }
        });
    });
</script>
@endsection