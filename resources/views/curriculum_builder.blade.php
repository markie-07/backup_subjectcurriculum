@extends('layouts.app')

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6 md:p-8">
        <div class="container mx-auto">
            
            {{-- Main Header --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Curriculum Builder</h1>
                        <p class="text-sm text-slate-500 mt-1">Design and manage your academic curriculums.</p>
                    </div>
                    <button id="addCurriculumButton" class="w-full mt-4 sm:mt-0 sm:w-auto flex items-center justify-center space-x-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        <span>Add Curriculum</span>
                    </button>
                </div>
            </div>

            {{-- Curriculums Section --}}
            <div class="bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-slate-700 mb-4 sm:mb-0">Existing Curriculums</h2>
                    <div class="relative w-full sm:w-72">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                        <input type="text" id="search-bar" placeholder="Search..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-10">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-200">Senior High</h3>
                        <div id="senior-high-curriculums" class="space-y-4 pt-2">
                            <p class="text-slate-500 text-sm py-4">No Senior High curriculums found.</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-200">College</h3>
                        <div id="college-curriculums" class="space-y-4 pt-2">
                           <p class="text-slate-500 text-sm py-4">No College curriculums found.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal for adding/editing a curriculum --}}
            <div id="addCurriculumModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out" id="modal-panel">
                        <div class="flex justify-between items-center pb-4 border-b border-slate-200">
                            <h2 id="modal-title" class="text-xl font-bold text-slate-800">Create New Curriculum</h2>
                            <button id="closeModalButton" class="text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100" aria-label="Close modal">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form id="curriculumForm" class="space-y-5 mt-6">
                            @csrf
                            <input type="hidden" id="curriculumId" name="curriculumId">
                            
                            <div>
                                <label for="curriculum" class="block text-sm font-medium text-slate-700 mb-1">Curriculum Name</label>
                                <input type="text" id="curriculum" name="curriculum" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"  required>
                            </div>
                            <div>
                                <label for="programCode" class="block text-sm font-medium text-slate-700 mb-1">Program Code</label>
                                <input type="text" id="programCode" name="programCode" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"  required>
                            </div>
                            <div>
                                <label for="academicYear" class="block text-sm font-medium text-slate-700 mb-1">Academic Year</label>
                                <input type="text" id="academicYear" name="academicYear" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"  required>
                            </div>
                            <div>
                                <label for="yearLevel" class="block text-sm font-medium text-slate-700 mb-1">Level</label>
                                <select id="yearLevel" name="yearLevel" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                                    <option value="" disabled selected>Select Level</option>
                                    <option value="Senior High">Senior High</option>
                                    <option value="College">College</option>
                                </select>
                            </div>
                            <div class="pt-4 flex justify-end gap-3">
                                <button type="button" id="cancelModalButton" class="px-5 py-2.5 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" id="submit-button" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Create
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Custom Alert/Notification -->
            <div id="notification" class="fixed top-5 right-5 z-[100] transition-all transform translate-x-[120%] duration-300 ease-out">
                 <!-- Content is generated by JS -->
            </div>
            
            <!-- Custom Confirmation Modal for Delete -->
            <div id="deleteConfirmationModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
                <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center transform scale-95 opacity-0 transition-all duration-300 ease-out" id="delete-modal-panel">
                    <div class="w-12 h-12 rounded-full bg-red-100 p-2 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800">Delete Curriculum</h3>
                    <p class="text-sm text-slate-500 mt-2">Are you sure you want to delete this? This action cannot be undone.</p>
                    <div class="mt-6 flex justify-center gap-4">
                        <button id="cancelDeleteButton" class="w-full px-6 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-all">Cancel</button>
                        <button id="confirmDeleteButton" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-all">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addCurriculumButton = document.getElementById('addCurriculumButton');
            const addCurriculumModal = document.getElementById('addCurriculumModal');
            const closeModalButton = document.getElementById('closeModalButton');
            const cancelModalButton = document.getElementById('cancelModalButton');
            const modalPanel = document.getElementById('modal-panel');
            const curriculumForm = document.getElementById('curriculumForm');
            const modalTitle = document.getElementById('modal-title');
            const submitButton = document.getElementById('submit-button');
            const curriculumIdField = document.getElementById('curriculumId');
            
            const seniorHighCurriculums = document.getElementById('senior-high-curriculums');
            const collegeCurriculums = document.getElementById('college-curriculums');
            const searchBar = document.getElementById('search-bar');

            const notification = document.getElementById('notification');
            const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            const deleteModalPanel = document.getElementById('delete-modal-panel');
            const cancelDeleteButton = document.getElementById('cancelDeleteButton');
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            let deleteId = null;

            const showNotification = (message, isSuccess = true) => {
                const successIcon = `<svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;
                const errorIcon = `<svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>`;
                const bgColor = isSuccess ? 'bg-emerald-500' : 'bg-rose-500';

                notification.innerHTML = `
                    <div class="flex items-center p-4 rounded-lg shadow-lg text-white ${bgColor}">
                        ${isSuccess ? successIcon : errorIcon}
                        <span class="text-sm font-medium">${message}</span>
                    </div>
                `;

                notification.classList.remove('translate-x-[120%]');
                notification.classList.add('translate-x-0');

                setTimeout(() => {
                    notification.classList.remove('translate-x-0');
                    notification.classList.add('translate-x-[120%]');
                }, 5000);
            };

            const showDeleteConfirmation = (id) => {
                deleteId = id;
                deleteConfirmationModal.classList.remove('hidden');
                setTimeout(() => {
                    deleteConfirmationModal.classList.remove('opacity-0');
                    deleteModalPanel.classList.remove('opacity-0', 'scale-95');
                }, 10);
            };

            const hideDeleteConfirmation = () => {
                deleteConfirmationModal.classList.add('opacity-0');
                deleteModalPanel.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    deleteConfirmationModal.classList.add('hidden');
                    deleteId = null;
                }, 300);
            };

            cancelDeleteButton.addEventListener('click', hideDeleteConfirmation);
            
            confirmDeleteButton.addEventListener('click', async () => {
                if (deleteId) {
                    try {
                        const response = await fetch(`/api/curriculums/${deleteId}`, { 
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            }
                        });
                        if (!response.ok) throw new Error('Failed to delete.');
                        
                        showNotification('Curriculum deleted successfully.', true);
                        fetchCurriculums();
                    } catch (error) {
                        showNotification('Error deleting curriculum.', false);
                        console.error('Error deleting curriculum:', error);
                    } finally {
                        hideDeleteConfirmation();
                    }
                }
            });

            const createCurriculumCard = (curriculum) => {
                const card = document.createElement('div');
                card.className = 'curriculum-card group relative bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4 hover:border-blue-500 hover:shadow-lg transition-all duration-300';
                card.dataset.name = curriculum.curriculum_name.toLowerCase();
                card.dataset.code = curriculum.program_code.toLowerCase();
                card.dataset.id = curriculum.id;

                const date = new Date(curriculum.created_at);
                const formattedDate = date.toLocaleDateString('en-US', {
                    year: 'numeric', month: 'short', day: 'numeric'
                });
                const formattedTime = date.toLocaleTimeString('en-US', {
                    hour: '2-digit', minute: '2-digit', hour12: true
                });


                card.innerHTML = `
                    <div class="flex-shrink-0 w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-300">
                        <svg class="w-6 h-6 text-slate-500 group-hover:text-blue-600 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="flex-grow cursor-pointer" onclick="window.location.href='/subject_mapping?curriculumId=${curriculum.id}'">
                        <h3 class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors duration-300">${curriculum.curriculum_name}</h3>
                        <p class="text-sm text-slate-500">
                            ${curriculum.program_code} &middot; ${curriculum.academic_year}
                        </p>
                        <p class="text-xs text-slate-400 mt-1">Created: ${formattedDate} at ${formattedTime}</p>
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="edit-btn p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-100 rounded-md transition-colors" data-id="${curriculum.id}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"></path></svg>
                        </button>
                        <button class="delete-btn p-2 text-slate-400 hover:text-red-600 hover:bg-red-100 rounded-md transition-colors" data-id="${curriculum.id}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                `;
                return card;
            };

            const renderCurriculums = (curriculums) => {
                seniorHighCurriculums.innerHTML = '';
                collegeCurriculums.innerHTML = '';
                let seniorHighCount = 0;
                let collegeCount = 0;

                curriculums.forEach(curriculum => {
                    const card = createCurriculumCard(curriculum);
                    if (curriculum.year_level === 'Senior High') {
                        seniorHighCurriculums.appendChild(card);
                        seniorHighCount++;
                    } else {
                        collegeCurriculums.appendChild(card);
                        collegeCount++;
                    }
                });

                if (seniorHighCount === 0) seniorHighCurriculums.innerHTML = '<p class="text-slate-500 text-sm py-4">No Senior High curriculums found.</p>';
                if (collegeCount === 0) collegeCurriculums.innerHTML = '<p class="text-slate-500 text-sm py-4">No College curriculums found.</p>';
                
                attachActionListeners();
            };
            
            const fetchCurriculums = () => {
                fetch('/api/curriculums')
                    .then(response => response.json())
                    .then(renderCurriculums)
                    .catch(error => {
                        console.error('Error fetching curriculums:', error);
                        seniorHighCurriculums.innerHTML = '<p class="text-red-500">Failed to load curriculums.</p>';
                        collegeCurriculums.innerHTML = '<p class="text-red-500">Failed to load curriculums.</p>';
                    });
            };

            const showModal = (isEdit = false, curriculum = null) => {
                curriculumForm.reset();
                if (isEdit && curriculum) {
                    modalTitle.textContent = 'Edit Curriculum';
                    submitButton.textContent = 'Update';
                    curriculumIdField.value = curriculum.id;
                    document.getElementById('curriculum').value = curriculum.curriculum;
                    document.getElementById('programCode').value = curriculum.program_code;
                    document.getElementById('academicYear').value = curriculum.academic_year;
                    document.getElementById('yearLevel').value = curriculum.year_level;
                } else {
                    modalTitle.textContent = 'Create New Curriculum';
                    submitButton.textContent = 'Create';
                    curriculumIdField.value = '';
                }
                addCurriculumModal.classList.remove('hidden');
                setTimeout(() => {
                    addCurriculumModal.classList.remove('opacity-0');
                    modalPanel.classList.remove('opacity-0', 'scale-95');
                }, 10);
            };

            const hideModal = () => {
                addCurriculumModal.classList.add('opacity-0');
                modalPanel.classList.add('opacity-0', 'scale-95');
                setTimeout(() => addCurriculumModal.classList.add('hidden'), 300);
            };

            const handleFormSubmit = async (e) => {
                e.preventDefault();
                const id = curriculumIdField.value;
                const method = id ? 'PUT' : 'POST';
                const url = id ? `/api/curriculums/${id}` : '/api/curriculums';

                const formData = new FormData(curriculumForm);
                const payload = {
                    curriculum: formData.get('curriculum'),
                    programCode: formData.get('programCode'),
                    academicYear: formData.get('academicYear'),
                    yearLevel: formData.get('yearLevel'),
                };

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload)
                    });
                    
                    if (!response.ok) {
                        const errorData = await response.json();
                        throw errorData;
                    }
                    
                    hideModal();
                    fetchCurriculums();
                    showNotification(`Curriculum ${id ? 'updated' : 'created'} successfully!`, true);
                } catch (error) {
                    console.error('Error submitting form:', error);
                    let errorMessage = 'An error occurred. Please try again.';
                     if (error.message) {
                        errorMessage = error.message;
                        if(error.error) {
                            errorMessage += ` (Details: ${error.error})`;
                        }
                    }
                    showNotification(errorMessage, false);
                }
            };
            
            const attachActionListeners = () => {
                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', async (e) => {
                        e.stopPropagation();
                        const id = e.currentTarget.dataset.id;
                        
                        try {
                            const response = await fetch(`/api/curriculums/${id}`);
                            const data = await response.json();

                            if (!response.ok) {
                                throw data;
                            }
                            
                            if (data.curriculum) {
                                showModal(true, data.curriculum);
                            } else {
                                throw new Error('Invalid data format received from server.');
                            }
                        } catch (error) {
                           console.error('Error fetching curriculum data:', error);
                            let errorMessage = 'Failed to load curriculum data.';
                            if (error.message) {
                                errorMessage = error.message;
                                if(error.error) {
                                    errorMessage += ` (Details: ${error.error})`;
                                }
                            }
                           showNotification(errorMessage, false);
                        }
                    });
                });

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const id = e.currentTarget.dataset.id;
                        showDeleteConfirmation(id);
                    });
                });
            };

            searchBar.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                document.querySelectorAll('.curriculum-card').forEach(card => {
                    const name = card.dataset.name;
                    const code = card.dataset.code;
                    card.style.display = (name.includes(searchTerm) || code.includes(searchTerm)) ? 'flex' : 'none';
                });
            });

            addCurriculumButton.addEventListener('click', () => showModal());
            closeModalButton.addEventListener('click', hideModal);
            cancelModalButton.addEventListener('click', hideModal);
            addCurriculumModal.addEventListener('click', (e) => {
                if (e.target.id === 'addCurriculumModal') hideModal();
            });
            curriculumForm.addEventListener('submit', handleFormSubmit);

            fetchCurriculums();
        });
    </script>
@endsection

