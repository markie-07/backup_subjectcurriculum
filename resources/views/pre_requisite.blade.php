@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    {{-- The 'container' and 'mx-auto' classes have been removed from this div --}}
    <div>
        <div class="bg-white p-6 rounded-2xl shadow-lg mb-8">
            <div class="flex flex-col md:flex-row justify-between md:items-center">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold text-gray-800">Set Subject Prerequisites</h1>
                    <p class="text-sm text-gray-500 mt-1">Define the relationships between subjects for a curriculum.</p>
                </div>
                <button id="setPrerequisiteBtn" class="bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-800 transition-colors shadow-md flex items-center gap-2 disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Set Prerequisite
                </button>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <div class="mb-6 pb-6 border-b border-gray-200">
                <label for="curriculum-selector-button" class="block text-lg font-semibold text-gray-700 mb-2">Select Curriculum to View</label>
                <div id="custom-curriculum-selector" class="relative">
                    <button type="button" id="curriculum-selector-button" class="w-full border border-gray-300 rounded-lg p-3 flex justify-between items-center bg-white text-left focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500 truncate pr-2">-- Select a Curriculum --</span>
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="curriculum-dropdown-panel" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden">
                        <div class="p-2">
                            <input type="text" id="curriculum-search-input" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Search for a curriculum...">
                        </div>
                        <ul id="curriculum-options-list" class="max-h-60 overflow-y-auto">
                            @foreach($curriculums as $curriculum)
                                <li class="px-4 py-2 hover:bg-blue-100 cursor-pointer" data-value="{{ $curriculum->id }}" data-name="{{ $curriculum->curriculum }} ({{ $curriculum->program_code }})">
                                    {{ $curriculum->curriculum }} ({{ $curriculum->program_code }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <h2 class="text-xl font-bold text-gray-800 mb-4">Prerequisite Chain</h2>
            <div id="prerequisiteChain" class="space-y-4 text-gray-700">
                <p class="text-center text-gray-500 py-8">Select a curriculum from the dropdown above to view its prerequisite chain.</p>
            </div>
        </div>
    </div>
</main>

{{-- Modal for Setting Prerequisites --}}
<div id="prerequisiteModal" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-75 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-8 transform opacity-0 scale-95 transition-all">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Set Prerequisites</h2>
            <form id="prerequisiteForm">
                @csrf
                <div class="space-y-6">
                    <input type="hidden" id="modalCurriculumId" name="curriculum_id">
                    <input type="hidden" id="modalSubjectCode" name="subject_code">
                    <div class="bg-gray-100 p-3 rounded-lg border">
                        <p class="text-sm font-semibold text-gray-600">Curriculum:</p>
                        <p id="modalCurriculumName" class="text-lg font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <label for="modal-subject-selector-button" class="block text-sm font-semibold text-gray-700 mb-1">Subject (Takes the Prerequisites)</label>
                        <div id="modal-custom-subject-selector" class="relative">
                            <button type="button" id="modal-subject-selector-button" class="w-full border border-gray-300 rounded-lg p-3 flex justify-between items-center bg-white text-left focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <span class="text-gray-500 truncate pr-2">Select a curriculum first</span>
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div id="modal-subject-dropdown-panel" class="absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden">
                                <div class="p-2">
                                    <input type="text" id="modal-subject-search-input" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Search for a subject...">
                                </div>
                                <ul id="modal-subject-options-list" class="max-h-60 overflow-y-auto">
                                    </ul>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Prerequisite Subjects (Select one or more)</label>
                        <div id="prerequisiteList" class="max-h-60 overflow-y-auto bg-gray-50 border border-gray-200 rounded-lg p-4 space-y-3">
                            <p class="text-gray-500">Select a subject to see available prerequisites.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-4">
                    <button type="button" id="cancelModalBtn" class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">Cancel</button>
                    <button type="submit" id="savePrerequisitesBtn" class="px-6 py-3 rounded-lg text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-colors" disabled>Save Prerequisites</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- State Management ---
    let allSubjectsForCurriculum = [];
    let selectedCurriculum = { id: null, name: '-- Select a Curriculum --' };
    let selectedModalSubject = { code: null, name: 'Select a Subject' };

    // --- Main Page Elements ---
    const setPrerequisiteBtn = document.getElementById('setPrerequisiteBtn');
    const prerequisiteChainContainer = document.getElementById('prerequisiteChain');
    
    // --- Main Curriculum Searchable Dropdown Elements ---
    const mainCustomSelector = document.getElementById('custom-curriculum-selector');
    const mainSelectorButton = document.getElementById('curriculum-selector-button');
    const mainDropdownPanel = document.getElementById('curriculum-dropdown-panel');
    const mainSearchInput = document.getElementById('curriculum-search-input');
    const mainOptionsList = document.getElementById('curriculum-options-list');

    // --- Modal Elements ---
    const prerequisiteModal = document.getElementById('prerequisiteModal');
    const modalPanel = prerequisiteModal.querySelector('.transform');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const modalCurriculumIdInput = document.getElementById('modalCurriculumId');
    const modalCurriculumName = document.getElementById('modalCurriculumName');
    const modalSubjectCodeInput = document.getElementById('modalSubjectCode');
    const prerequisiteList = document.getElementById('prerequisiteList');
    const prerequisiteForm = document.getElementById('prerequisiteForm');
    const savePrerequisitesBtn = document.getElementById('savePrerequisitesBtn');
    
    // --- Modal Subject Searchable Dropdown Elements ---
    const modalCustomSelector = document.getElementById('modal-custom-subject-selector');
    const modalSelectorButton = document.getElementById('modal-subject-selector-button');
    const modalDropdownPanel = document.getElementById('modal-subject-dropdown-panel');
    const modalSearchInput = document.getElementById('modal-subject-search-input');
    const modalOptionsList = document.getElementById('modal-subject-options-list');

    // --- Main Curriculum Dropdown Logic ---
    mainSelectorButton.addEventListener('click', (e) => {
        e.stopPropagation();
        mainDropdownPanel.classList.toggle('hidden');
    });

    mainSearchInput.addEventListener('input', () => {
        const filter = mainSearchInput.value.toLowerCase();
        mainOptionsList.querySelectorAll('li').forEach(option => {
            option.style.display = option.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    mainOptionsList.addEventListener('click', (e) => {
        if (e.target.tagName === 'LI') {
            selectedCurriculum.id = e.target.dataset.value;
            selectedCurriculum.name = e.target.dataset.name;
            mainSelectorButton.querySelector('span').textContent = selectedCurriculum.name;
            mainSelectorButton.querySelector('span').classList.remove('text-gray-500');
            mainDropdownPanel.classList.add('hidden');
            fetchPrerequisiteData(selectedCurriculum.id);
        }
    });

    document.addEventListener('click', (e) => {
        if (!mainCustomSelector.contains(e.target)) mainDropdownPanel.classList.add('hidden');
        if (!modalCustomSelector.contains(e.target)) modalDropdownPanel.classList.add('hidden');
    });

    // --- Modal Subject Dropdown Logic ---
    modalSelectorButton.addEventListener('click', (e) => {
        e.stopPropagation();
        modalDropdownPanel.classList.toggle('hidden');
    });

    modalSearchInput.addEventListener('input', () => {
        const filter = modalSearchInput.value.toLowerCase();
        modalOptionsList.querySelectorAll('li').forEach(option => {
            option.style.display = option.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    modalOptionsList.addEventListener('click', (e) => {
        if (e.target.tagName === 'LI') {
            selectedModalSubject.code = e.target.dataset.value;
            selectedModalSubject.name = e.target.dataset.name;
            modalSelectorButton.querySelector('span').textContent = selectedModalSubject.name;
            modalSelectorButton.querySelector('span').classList.remove('text-gray-500');
            modalDropdownPanel.classList.add('hidden');
            handleSubjectSelection(selectedModalSubject.code);
        }
    });

    // --- Modal Controls ---
    const showModal = (subjectCodeToEdit = null) => {
        if (!selectedCurriculum.id) {
            alert('Please select a curriculum from the main dropdown first.');
            return;
        }
        
        modalCurriculumIdInput.value = selectedCurriculum.id;
        modalCurriculumName.textContent = selectedCurriculum.name;
        
        fetchSubjectsForModal(selectedCurriculum.id).then(() => {
            if (subjectCodeToEdit) {
                const subject = allSubjectsForCurriculum.find(s => s.subject_code === subjectCodeToEdit);
                if (subject) {
                    selectedModalSubject.code = subject.subject_code;
                    selectedModalSubject.name = `${subject.subject_name} (${subject.subject_code})`;
                    modalSelectorButton.querySelector('span').textContent = selectedModalSubject.name;
                    modalSelectorButton.querySelector('span').classList.remove('text-gray-500');
                    handleSubjectSelection(subjectCodeToEdit);
                }
            }
        });

        prerequisiteModal.classList.remove('hidden');
        setTimeout(() => modalPanel.classList.remove('opacity-0', 'scale-95'), 10);
    };

    const hideModal = () => {
        modalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            prerequisiteModal.classList.add('hidden');
            prerequisiteForm.reset();
            modalOptionsList.innerHTML = '';
            prerequisiteList.innerHTML = '<p class="text-gray-500">Select a subject to see available prerequisites.</p>';
            modalSelectorButton.querySelector('span').textContent = 'Select a curriculum first';
            modalSelectorButton.querySelector('span').classList.add('text-gray-500');
            savePrerequisitesBtn.disabled = true;
        }, 300);
    };

    setPrerequisiteBtn.addEventListener('click', () => showModal());
    cancelModalBtn.addEventListener('click', hideModal);
    prerequisiteModal.addEventListener('click', (e) => {
        if (e.target === prerequisiteModal) hideModal();
    });

    // --- Data Fetching and UI Rendering ---
    async function fetchPrerequisiteData(curriculumId) {
        if (!curriculumId) {
            prerequisiteChainContainer.innerHTML = '<p class="text-center text-gray-500 py-8">Select a curriculum from the dropdown above to view its prerequisite chain.</p>';
            setPrerequisiteBtn.disabled = true;
            return;
        }

        prerequisiteChainContainer.innerHTML = '<p class="text-center text-gray-500 py-8">Loading chain...</p>';
        setPrerequisiteBtn.disabled = false;

        try {
            const response = await fetch(`/api/prerequisites/${curriculumId}`);
            if (!response.ok) throw new Error('Failed to fetch data.');
            
            const data = await response.json();
            renderPrerequisiteChain(data.prerequisites || {}, data.subjects || []);
        } catch (error) {
            console.error('Error fetching prerequisite data:', error);
            prerequisiteChainContainer.innerHTML = '<p class="text-center text-red-500 py-8">Could not load prerequisite data.</p>';
        }
    }

    async function fetchSubjectsForModal(curriculumId) {
        try {
            const response = await fetch(`/api/prerequisites/${curriculumId}`);
            if (!response.ok) throw new Error('Failed to fetch subjects.');
            
            const data = await response.json();
            allSubjectsForCurriculum = data.subjects || [];
            populateSubjectDropdown(allSubjectsForCurriculum);
        } catch (error) {
            console.error('Error fetching subjects for modal:', error);
            modalOptionsList.innerHTML = '<li>Could not load subjects</li>';
        }
    }

    function populateSubjectDropdown(subjects) {
        modalOptionsList.innerHTML = '';
        modalSelectorButton.querySelector('span').textContent = subjects.length > 0 ? 'Select a Subject' : 'No subjects available';
        modalSelectorButton.disabled = subjects.length === 0;

        subjects.forEach(subject => {
            const li = document.createElement('li');
            li.className = 'px-4 py-2 hover:bg-blue-100 cursor-pointer';
            li.dataset.value = subject.subject_code;
            const subjectName = `${subject.subject_name} (${subject.subject_code})`;
            li.dataset.name = subjectName;
            li.textContent = subjectName;
            modalOptionsList.appendChild(li);
        });
    }

    function populatePrerequisiteCheckboxes(selectedSubjectCode, existingPrerequisites = []) {
        prerequisiteList.innerHTML = '';
        const eligibleSubjects = allSubjectsForCurriculum.filter(s => s.subject_code !== selectedSubjectCode);

        if (eligibleSubjects.length === 0) {
            prerequisiteList.innerHTML = '<p class="text-gray-500">No other subjects available to be prerequisites.</p>';
            return;
        }

        eligibleSubjects.forEach(subject => {
            const isChecked = existingPrerequisites.includes(subject.subject_code);
            const checkboxWrapper = document.createElement('div');
            checkboxWrapper.className = 'flex items-center';
            checkboxWrapper.innerHTML = `
                <input type="checkbox" id="prereq-${subject.subject_code}" name="prerequisite_codes[]" value="${subject.subject_code}" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" ${isChecked ? 'checked' : ''}>
                <label for="prereq-${subject.subject_code}" class="ml-3 text-sm text-gray-700">${subject.subject_name} (${subject.subject_code})</label>
            `;
            prerequisiteList.appendChild(checkboxWrapper);
        });
    }

    function renderPrerequisiteChain(prerequisites, subjects) {
        prerequisiteChainContainer.innerHTML = '';
        if (Object.keys(prerequisites).length === 0) {
            prerequisiteChainContainer.innerHTML = '<p class="text-center text-gray-500 py-8">No prerequisites have been set for this curriculum yet.</p>';
            return;
        }
        const subjectMap = new Map(subjects.map(s => [s.subject_code, s.subject_name]));
        for (const subjectCode in prerequisites) {
            const prereqs = prerequisites[subjectCode];
            if (prereqs.length > 0) {
                const chainDiv = document.createElement('div');
                chainDiv.className = 'flex items-center justify-between gap-2 p-3 bg-gray-50 rounded-lg border';
                
                const subjectName = subjectMap.get(subjectCode) || subjectCode;
                const subjectHtml = `<span class="font-semibold bg-blue-200 text-blue-800 px-2 py-1 rounded">${subjectName}</span>`;

                const prereqHtml = prereqs.map(p => {
                    const prereqName = subjectMap.get(p.prerequisite_subject_code) || p.prerequisite_subject_code;
                    return `<span class="font-semibold bg-yellow-200 text-yellow-800 px-2 py-1 rounded">${prereqName}</span>`;
                }).join(' <span class="font-bold text-2xl text-gray-400 mx-2">&rarr;</span> ');

                chainDiv.innerHTML = `
                    <div class="flex-grow flex flex-wrap items-center gap-2">
                        ${subjectHtml}
                        <span class="font-bold text-2xl text-gray-400 mx-2">&rarr;</span>
                        ${prereqHtml}
                    </div>
                    <button class="edit-prereq-btn p-2 text-blue-600 hover:text-blue-800 rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" data-subject-code="${subjectCode}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"></path></svg>
                    </button>
                `;
                prerequisiteChainContainer.appendChild(chainDiv);
            }
        }
        addEditButtonListeners();
    }
    
    function addEditButtonListeners() {
        document.querySelectorAll('.edit-prereq-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const subjectCodeToEdit = e.target.closest('button').dataset.subjectCode;
                showModal(subjectCodeToEdit);
            });
        });
    }

    // --- Event Listeners & Handlers ---
    async function handleSubjectSelection(subjectCode) {
        modalSubjectCodeInput.value = subjectCode; // Update hidden input for form submission
        savePrerequisitesBtn.disabled = !subjectCode;

        if (!subjectCode || !selectedCurriculum.id) {
            prerequisiteList.innerHTML = '<p class="text-gray-500">Select a subject to see available prerequisites.</p>';
            return;
        }
        const response = await fetch(`/api/prerequisites/${selectedCurriculum.id}`);
        const data = await response.json();
        const existingPrerequisites = data.prerequisites[subjectCode] ? data.prerequisites[subjectCode].map(p => p.prerequisite_subject_code) : [];
        populatePrerequisiteCheckboxes(subjectCode, existingPrerequisites);
    }

    prerequisiteForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        savePrerequisitesBtn.disabled = true;
        const formData = new FormData(prerequisiteForm);
        const data = {
            curriculum_id: formData.get('curriculum_id'),
            subject_code: formData.get('subject_code'),
            prerequisite_codes: formData.getAll('prerequisite_codes[]')
        };
        try {
            const response = await fetch('/api/prerequisites', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to save prerequisites.');
            }
            alert('Prerequisites saved successfully!');
            hideModal();
            fetchPrerequisiteData(data.curriculum_id);
        } catch (error) {
            console.error('Error saving prerequisites:', error);
            alert('Error: ' + error.message);
        } finally {
            savePrerequisitesBtn.disabled = false;
        }
    });

    // --- Initial Load ---
    const urlParams = new URLSearchParams(window.location.search);
    const curriculumIdFromUrl = urlParams.get('curriculumId');
    if (curriculumIdFromUrl) {
        const optionToSelect = mainOptionsList.querySelector(`li[data-value="${curriculumIdFromUrl}"]`);
        if (optionToSelect) {
            selectedCurriculum.id = curriculumIdFromUrl;
            selectedCurriculum.name = optionToSelect.dataset.name;
            mainSelectorButton.querySelector('span').textContent = selectedCurriculum.name;
            mainSelectorButton.querySelector('span').classList.remove('text-gray-500');
            fetchPrerequisiteData(curriculumIdFromUrl);
            showModal();
        }
    }
});
</script>
@endsection