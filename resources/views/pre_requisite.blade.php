@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-y-auto bg-gray-100 p-8">
    <div class="bg-white p-8 rounded-3xl shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Prerequisites Configuration</h2>
            <button id="setPrerequisitesButton" class="mt-4 sm:mt-0 bg-blue-600 text-white px-6 py-2.5 rounded-3xl text-sm font-medium hover:bg-blue-700 transition duration-300 flex items-center justify-center space-x-2 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                <span>Set Prerequisites</span>
            </button>
        </div>

        <div class="mb-8">
             <label for="mainCurriculumDropdown" class="block text-gray-700 font-semibold mb-2">Select Curriculum to View Chain</label>
            <div class="relative w-full">
                <select id="mainCurriculumDropdown" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-2xl leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-base shadow-sm">
                    {{-- Options populated by JavaScript --}}
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="text-xl font-bold text-gray-800">Prerequisite Chain</h3>
            <div id="prerequisiteChainContainer" class="space-y-4">
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                    <p class="text-center text-gray-500">
                        Select a curriculum, then click "Set Prerequisites" to build the chain. The saved chain will appear here.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<div id="prerequisitesModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden transition-opacity duration-300 opacity-0">
    <div id="modal-panel" class="bg-white p-8 rounded-3xl shadow-xl transform transition-all duration-300 sm:w-1/2 scale-95 opacity-0">
        <div class="flex items-center justify-between pb-4 border-b">
            <div>
                <h3 class="text-2xl font-bold text-gray-800">Set Prerequisites</h3>
                <p class="text-sm text-gray-500">Define the prerequisites for a selected subject.</p>
            </div>
            <button id="closeModalButton" class="text-gray-400 hover:text-gray-600 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="mt-4 space-y-6">
            <div>
                <label for="modalCurriculumDropdown" class="block text-gray-700 font-semibold mb-2">Curriculum</label>
                <div class="relative">
                    <select id="modalCurriculumDropdown" class="block w-full appearance-none bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-2xl leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-base shadow-sm">
                        {{-- Options will be populated by JavaScript --}}
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                </div>
            </div>

            <div>
                <label for="subjectSelector" class="block text-gray-700 font-semibold mb-2">Subject (Takes the Prerequisites)</label>
                <div class="relative">
                    <select id="subjectSelector" class="block w-full appearance-none bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-2xl leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-base shadow-sm">
                        {{-- Options populated based on curriculum --}}
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                </div>
            </div>

            <div>
                <label for="prerequisites-input" class="block text-gray-700 font-semibold mb-2">Prerequisite Subjects (Select one or more)</label>
                <div id="prerequisites-input-container" class="relative">
                    <input type="text" id="prerequisites-input" readonly placeholder="Click to select prerequisites" class="block w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-2xl leading-tight focus:outline-none focus:ring focus:border-blue-500 shadow-sm cursor-pointer">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
                <div id="prerequisites-checklist" class="hidden absolute z-10 w-full mt-2 bg-white rounded-md shadow-lg border border-gray-300 max-h-48 overflow-y-auto">
                    <div class="p-4 space-y-2">
                        </div>
                </div>
            </div>

        </div>
        <div class="mt-6 flex justify-end space-x-4">
            <button id="cancelModalButton" class="bg-gray-300 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-400 transition duration-300 shadow-md">CANCEL</button>
            <button id="saveModalButton" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-300 shadow-md">SAVE</button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successPrereqModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden transition-opacity duration-300 opacity-0">
    <div class="bg-white p-8 rounded-3xl shadow-xl text-center w-full max-w-sm">
        <div class="flex justify-center mb-4">
            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Success!</h3>
        <p class="text-sm text-gray-600 mb-6">Prerequisites saved successfully.</p>
        <button id="closeSuccessPrereqModalButton" class="w-full px-6 py-3 rounded-lg text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-colors">OK</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const prerequisitesModal = document.getElementById('prerequisitesModal');
        const setPrerequisitesButton = document.getElementById('setPrerequisitesButton');
        const closeModalButton = document.getElementById('closeModalButton');
        const cancelModalButton = document.getElementById('cancelModalButton');
        const saveModalButton = document.getElementById('saveModalButton');
        const modalPanel = document.getElementById('modal-panel');

        const mainCurriculumDropdown = document.getElementById('mainCurriculumDropdown');
        const modalCurriculumDropdown = document.getElementById('modalCurriculumDropdown');
        const subjectSelector = document.getElementById('subjectSelector');
        const prerequisiteChainContainer = document.getElementById('prerequisiteChainContainer');
        
        const prerequisitesInput = document.getElementById('prerequisites-input');
        const prerequisitesChecklist = document.getElementById('prerequisites-checklist');
        const prerequisitesChecklistContainer = prerequisitesChecklist.querySelector('div');

        let prerequisiteData = {};

        function fetchAllCurriculums() {
            fetch('/api/curriculums')
                .then(response => response.json())
                .then(curriculums => {
                    mainCurriculumDropdown.innerHTML = '<option value="">Select a Curriculum</option>';
                    modalCurriculumDropdown.innerHTML = '<option value="">Select a Curriculum</option>';

                    curriculums.forEach(curriculum => {
                        const option = document.createElement('option');
                        option.value = curriculum.id;
                        option.textContent = curriculum.name;
                        mainCurriculumDropdown.appendChild(option.cloneNode(true));
                        modalCurriculumDropdown.appendChild(option);
                    });

                    const urlParams = new URLSearchParams(window.location.search);
                    const curriculumIdFromUrl = urlParams.get('curriculumId');
                    if (curriculumIdFromUrl) {
                        mainCurriculumDropdown.value = curriculumIdFromUrl;
                        fetchPrerequisitesForCurriculum(curriculumIdFromUrl).then(() => {
                           renderPrerequisiteChain();
                        });
                        openModal();
                    }
                })
                .catch(error => console.error('Error fetching curriculums:', error));
        }
        
        function fetchSubjectsForCurriculum(curriculumId) {
            if (!curriculumId) {
                subjectSelector.innerHTML = '';
                prerequisitesChecklistContainer.innerHTML = '';
                return;
            }
            fetch(`/api/curriculums/${curriculumId}/with-subjects`)
                .then(response => response.json())
                .then(data => {
                    populateSubjectDropdowns(data.subjects);
                })
                .catch(error => console.error(`Error fetching subjects for curriculum ${curriculumId}:`, error));
        }

        function fetchPrerequisitesForCurriculum(curriculumId) {
            return fetch(`/api/prerequisites/${curriculumId}`)
                .then(response => response.json())
                .then(data => {
                    prerequisiteData[curriculumId] = data;
                })
                .catch(error => console.error(`Error fetching prerequisites for curriculum ${curriculumId}:`, error));
        }

        function populateSubjectDropdowns(subjects) {
            subjectSelector.innerHTML = '<option value="">Select Subject</option>';
            prerequisitesChecklistContainer.innerHTML = '';

            subjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.subject_code;
                option.textContent = `${subject.subject_name} (${subject.subject_code})`;
                subjectSelector.appendChild(option);

                const checkboxDiv = document.createElement('div');
                checkboxDiv.className = 'flex items-center';
                checkboxDiv.innerHTML = `
                    <input type="checkbox" id="prereq-${subject.subject_code}" name="prerequisite" value="${subject.subject_code}" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="prereq-${subject.subject_code}" class="ml-2 text-sm text-gray-700">${subject.subject_name} (${subject.subject_code})</label>
                `;
                prerequisitesChecklistContainer.appendChild(checkboxDiv);
            });
        }
        
        function renderPrerequisiteChain() {
            const curriculumId = mainCurriculumDropdown.value;
            prerequisiteChainContainer.innerHTML = '';

            if (!curriculumId || !prerequisiteData[curriculumId] || Object.keys(prerequisiteData[curriculumId]).length === 0) {
                prerequisiteChainContainer.innerHTML = `
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                        <p class="text-center text-gray-500">No prerequisites set for this curriculum. Click "Set Prerequisites" to begin.</p>
                    </div>`;
                return;
            }

            const chains = prerequisiteData[curriculumId];
            let hasPrerequisites = false;

            for (const subjectCode in chains) {
                const prerequisites = chains[subjectCode];
                if (prerequisites.length === 0) continue;
                
                hasPrerequisites = true;
                
                const relationshipContainer = document.createElement('div');
                relationshipContainer.className = 'flex flex-wrap items-center justify-center gap-x-2 gap-y-2 p-3 bg-gray-50 rounded-2xl border';

                const allChainElements = [subjectCode, ...prerequisites];

                allChainElements.forEach((code, index) => {
                    const elementBox = document.createElement('div');
                    elementBox.textContent = code;
                    
                    if (index === 0) {
                        elementBox.className = 'text-center bg-green-100 text-green-800 px-4 py-2 rounded-lg font-semibold text-sm';
                    } else {
                        elementBox.className = 'text-center bg-blue-100 text-blue-800 px-4 py-2 rounded-lg font-semibold text-sm';
                    }
                    relationshipContainer.appendChild(elementBox);

                    if (index < allChainElements.length - 1) {
                        const arrowElement = document.createElement('div');
                        arrowElement.innerHTML = `<svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>`;
                        relationshipContainer.appendChild(arrowElement);
                    }
                });

                prerequisiteChainContainer.appendChild(relationshipContainer);
            }

            if (!hasPrerequisites) {
                 prerequisiteChainContainer.innerHTML = `
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                        <p class="text-center text-gray-500">No prerequisites set for this curriculum. Click "Set Prerequisites" to begin.</p>
                    </div>`;
            }
        }

        const openModal = () => {
            const mainSelection = mainCurriculumDropdown.value;
            if (mainSelection) {
                modalCurriculumDropdown.value = mainSelection;
                fetchSubjectsForCurriculum(mainSelection);
            }
            prerequisitesModal.classList.remove('hidden');
            setTimeout(() => {
                prerequisitesModal.classList.add('opacity-100');
                modalPanel.classList.remove('scale-95', 'opacity-0');
            }, 10);
        };

        const closeModal = () => {
            prerequisitesModal.classList.remove('opacity-100');
            modalPanel.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                prerequisitesModal.classList.add('hidden');
                prerequisitesChecklist.classList.add('hidden');
            }, 300);
        };

        // Success modal logic
        const successPrereqModal = document.getElementById('successPrereqModal');
        const closeSuccessPrereqModalButton = document.getElementById('closeSuccessPrereqModalButton');
        function showSuccessPrereqModal() {
            successPrereqModal.classList.remove('hidden');
            setTimeout(() => {
                successPrereqModal.classList.add('opacity-100');
            }, 10);
            // Auto-close after 2 seconds
            setTimeout(hideSuccessPrereqModal, 2000);
        }
        function hideSuccessPrereqModal() {
            successPrereqModal.classList.remove('opacity-100');
            setTimeout(() => {
                successPrereqModal.classList.add('hidden');
            }, 300);
        }
        closeSuccessPrereqModalButton.addEventListener('click', hideSuccessPrereqModal);
        successPrereqModal.addEventListener('click', (e) => {
            if (e.target === successPrereqModal) hideSuccessPrereqModal();
        });

        saveModalButton.addEventListener('click', () => {
            // **FIXED**: These lines were missing. They get the data from the modal.
            const curriculumId = modalCurriculumDropdown.value;
            const subject = subjectSelector.value;
            const selectedPrerequisites = Array.from(prerequisitesChecklist.querySelectorAll('input[name="prerequisite"]:checked')).map(cb => cb.value);

            if (!curriculumId || !subject) {
                alert('Please select a curriculum and a subject.');
                return;
            }

            if (selectedPrerequisites.includes(subject)) {
                 alert('A subject cannot be a prerequisite for itself.');
                return;
            }

            const payload = {
                curriculum_id: curriculumId,
                subject_code: subject,
                prerequisites: selectedPrerequisites,
            };

            fetch('/api/prerequisites', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    // This sends the CSRF token to prevent 419 errors
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
            .then(response => {
                if (!response.ok) {
                    // This will help show a more detailed error if something goes wrong
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                showSuccessPrereqModal();
                // **FIXED**: This part reloads the data and closes the modal after saving
                fetchPrerequisitesForCurriculum(curriculumId).then(() => {
                    mainCurriculumDropdown.value = curriculumId;
                    renderPrerequisiteChain();
                    closeModal();
                });
            })
            .catch(error => {
                console.error('Error saving prerequisites:', error);
                const errorMessage = error.message || 'An unknown error occurred. Check the console (F12) for details.';
                alert(`Error: ${errorMessage}`);
            });
        });

        setPrerequisitesButton.addEventListener('click', openModal);
        closeModalButton.addEventListener('click', closeModal);
        cancelModalButton.addEventListener('click', closeModal);

        modalCurriculumDropdown.addEventListener('change', (event) => {
            fetchSubjectsForCurriculum(event.target.value);
        });

        mainCurriculumDropdown.addEventListener('change', (event) => {
            const curriculumId = event.target.value;
            if(curriculumId) {
                fetchPrerequisitesForCurriculum(curriculumId).then(() => {
                    renderPrerequisiteChain();
                });
            } else {
                prerequisiteChainContainer.innerHTML = `
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                        <p class="text-center text-gray-500">Select a curriculum to view the prerequisite chain.</p>
                    </div>`;
            }
        });

        prerequisitesInput.addEventListener('click', () => {
            prerequisitesChecklist.classList.toggle('hidden');
        });

        prerequisitesChecklist.addEventListener('change', () => {
            const selected = Array.from(prerequisitesChecklist.querySelectorAll('input:checked')).map(cb => {
                const label = document.querySelector(`label[for="${cb.id}"]`);
                return label ? label.textContent.trim() : cb.value;
            });
            prerequisitesInput.value = selected.length > 0 ? selected.join(', ') : 'Click to select prerequisites';
        });

        subjectSelector.addEventListener('change', (event) => {
            const curriculumId = modalCurriculumDropdown.value;
            const subjectCode = event.target.value;
            const existingPrerequisites = (prerequisiteData[curriculumId] && prerequisiteData[curriculumId][subjectCode]) ? prerequisiteData[curriculumId][subjectCode] : [];

            prerequisitesChecklist.querySelectorAll('input[name="prerequisite"]').forEach(checkbox => {
                checkbox.checked = false;
            });

            existingPrerequisites.forEach(prereqCode => {
                const checkbox = prerequisitesChecklist.querySelector(`input[value="${prereqCode}"]`);
                if (checkbox) checkbox.checked = true;
            });

            prerequisitesInput.value = existingPrerequisites.length > 0 ? existingPrerequisites.map(code => {
                const label = document.querySelector(`label[for="prereq-${code}"]`);
                return label ? label.textContent.trim() : code;
            }).join(', ') : 'Click to select prerequisites';
        });

        fetchAllCurriculums();
    });
</script>
@endsection