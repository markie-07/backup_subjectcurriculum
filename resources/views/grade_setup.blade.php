@extends('layouts.app')

@section('content')
<style>
    /* Custom styles for the progress circle and modal transitions */
    .progress-ring__circle {
        transition: stroke-dashoffset 0.35s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
    .modal-panel {
        transition: all 0.3s ease-out;
    }
</style>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 sm:p-6 md:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        {{-- Grade Scheme Setup Form --}}
        <div class="lg:col-span-2 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-2xl shadow-lg border border-gray-200/80">
            <form id="grade-setup-form" onsubmit="return false;">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Grade Scheme Setup</h1>
                    <p class="text-sm text-gray-600 mt-1">Design and manage grading component weights for subjects.</p>
                    
                    <div class="flex items-center gap-3 border-b border-gray-200 pb-3 my-4">
                        <div class="w-10 h-10 flex-shrink-0 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-700">Select Subject</h2>
                    </div>
                    <div>
                        <label for="subject-select" class="block text-sm font-medium text-gray-600 mb-1">Subject / Course</label>
                        <div class="relative">
                            <select id="subject-select" class="w-full appearance-none py-3 pl-4 pr-10 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm transition-colors">
                                <option value="">Loading subjects...</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-3 border-b border-gray-200 pb-3 mb-6">
                       <div class="w-10 h-10 flex-shrink-0 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-700">Grade Components</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200"><label class="block text-sm font-medium text-gray-600 mb-1">AAE (%)</label><input type="number" id="aae-input" value="20" class="grade-input text-center text-lg font-bold w-full py-2 px-3 border-gray-300 rounded-md shadow-sm"></div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200"><label class="block text-sm font-medium text-gray-600 mb-1">Evaluation (%)</label><input type="number" id="evaluation-input" value="20" class="grade-input text-center text-lg font-bold w-full py-2 px-3 border-gray-300 rounded-md shadow-sm"></div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200"><label class="block text-sm font-medium text-gray-600 mb-1">Assignment (%)</label><input type="number" id="assignment-input" value="20" class="grade-input text-center text-lg font-bold w-full py-2 px-3 border-gray-300 rounded-md shadow-sm"></div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200"><label class="block text-sm font-medium text-gray-600 mb-1">Exam (%)</label><input type="number" id="exam-input" value="40" class="grade-input text-center text-lg font-bold w-full py-2 px-3 border-gray-300 rounded-md shadow-sm"></div>
                    </div>

                    <div class="mt-6 flex justify-center items-center p-4 bg-gray-100 rounded-lg"><div class="relative w-24 h-24"><svg class="w-full h-full" viewBox="0 0 100 100"><circle class="text-gray-200" stroke-width="10" stroke="currentColor" fill="transparent" r="45" cx="50" cy="50" /><circle id="progress-circle" class="progress-ring__circle text-indigo-500" stroke-width="10" stroke-linecap="round" stroke="currentColor" fill="transparent" r="45" cx="50" cy="50" /></svg><div class="absolute inset-0 flex items-center justify-center"><span id="total-weight" class="text-2xl font-bold text-gray-700">100%</span></div></div><p class="ml-4 font-semibold text-gray-600">Total Weight</p></div>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-200">
                    <button id="add-grade-btn" type="button" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 text-white font-bold py-3 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed disabled:shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" /></svg>
                        Set Grade Scheme
                    </button>
                </div>
            </form>
        </div>
        
        {{-- Grading Scale & Existing Setups --}}
        <div class="lg:col-span-1 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-2xl shadow-lg border border-gray-200/80">
            <h2 class="text-xl font-bold text-gray-700 mb-4 pb-3 border-b">Grading Scale</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr><th scope="col" class="px-4 py-3">Description</th><th scope="col" class="px-4 py-3">Numerical</th><th scope="col" class="px-4 py-3">Percentage</th></tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b"><td class="px-4 py-2">Excellent</td><td class="px-4 py-2">1.00</td><td class="px-4 py-2">98–100</td></tr>
                        <tr class="bg-gray-50 border-b"><td class="px-4 py-2">Very Good</td><td class="px-4 py-2">1.25</td><td class="px-4 py-2">95–97</td></tr>
                        <tr class="bg-white border-b"><td class="px-4 py-2"></td><td class="px-4 py-2">1.50</td><td class="px-4 py-2">92–94</td></tr>
                        <tr class="bg-gray-50 border-b"><td class="px-4 py-2">Good</td><td class="px-4 py-2">1.75</td><td class="px-4 py-2">89–91</td></tr>
                        <tr class="bg-white border-b"><td class="px-4 py-2"></td><td class="px-4 py-2">2.00</td><td class="px-4 py-2">86–88</td></tr>
                        <tr class="bg-gray-50 border-b"><td class="px-4 py-2">Satisfactory</td><td class="px-4 py-2">2.25</td><td class="px-4 py-2">83–85</td></tr>
                        <tr class="bg-white border-b"><td class="px-4 py-2"></td><td class="px-4 py-2">2.50</td><td class="px-4 py-2">80–82</td></tr>
                        <tr class="bg-gray-50 border-b"><td class="px-4 py-2">Fair</td><td class="px-4 py-2">2.75</td><td class="px-4 py-2">77–79</td></tr>
                        <tr class="bg-white border-b"><td class="px-4 py-2">Passed</td><td class="px-4 py-2">3.00</td><td class="px-4 py-2">75–76</td></tr>
                        <tr class="bg-gray-50 border-b"><td class="px-4 py-2">Failed</td><td class="px-4 py-2">5.00</td><td class="px-4 py-2">74 & below</td></tr>
                        <tr class="bg-white border-b"><td class="px-4 py-2">*No Grade</td><td class="px-4 py-2">NG</td><td class="px-4 py-2">–</td></tr>
                        <tr class="bg-gray-50"><td class="px-4 py-2">Dropped</td><td class="px-4 py-2">DRP</td><td class="px-4 py-2">–</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="lg:col-span-1 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-2xl shadow-lg border border-gray-200/80">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-700 mb-4 sm:mb-0">Existing Setups</h2>
                <div class="relative w-full sm:w-auto"><svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg><input type="text" id="search-input" placeholder="Search..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors"></div>
            </div>
            <div id="existing-grades-container" class="space-y-3 max-h-[65vh] overflow-y-auto pr-2 -mr-2 mt-6">
                <p class="text-center text-gray-500 py-8">No grade schemes have been set yet.</p>
            </div>
        </div>
    </div>
</main>

{{-- Grade Detail Modal --}}
<div id="gradeDetailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 modal-panel transform scale-95 opacity-0">
        <div class="p-6">
            <div class="flex justify-between items-center pb-3 border-b mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-800" id="modalSubjectTitle"></h3>
                    <p class="text-sm text-gray-500" id="modalSubjectCode"></p>
                </div>
                <button id="closeDetailModalBtn" class="p-2 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-600">&times;</button>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg"><span class="text-gray-600">AAE:</span> <span id="modalAae" class="font-bold text-gray-800 text-lg"></span></div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg"><span class="text-gray-600">Evaluation:</span> <span id="modalEvaluation" class="font-bold text-gray-800 text-lg"></span></div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg"><span class="text-gray-600">Assignment:</span> <span id="modalAssignment" class="font-bold text-gray-800 text-lg"></span></div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg"><span class="text-gray-600">Exam:</span> <span id="modalExam" class="font-bold text-gray-800 text-lg"></span></div>
                <div class="flex justify-between items-center p-3 bg-indigo-50 rounded-lg border border-indigo-200"><span class="font-semibold text-indigo-600">Total:</span> <span id="modalTotal" class="font-bold text-indigo-800 text-lg"></span></div>
            </div>
            <div class="mt-6 pt-4 border-t flex justify-end">
                <button id="editGradeBtn" type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Edit</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Confirmation Modal --}}
<div id="editConfirmationModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 modal-panel transform scale-95 opacity-0 text-center p-6">
        <h3 class="text-xl font-bold text-gray-800">Confirm Edit</h3>
        <p class="text-gray-600 mt-2">Are you sure you want to edit this grade scheme? The form will be populated with its current values.</p>
        <div class="flex justify-center gap-4 mt-6">
            <button id="cancelEditBtn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300">Cancel</button>
            <button id="confirmEditBtn" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-600">Yes, Edit</button>
        </div>
    </div>
</div>

{{-- Success Modal --}}
<div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
    <div class="bg-white rounded-lg p-8 shadow-xl text-center modal-panel transform scale-95 opacity-0">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h3 id="successModalTitle" class="text-2xl font-bold text-gray-800"></h3>
        <p id="successModalMessage" class="text-gray-600 mt-2"></p>
        <button id="closeSuccessModalBtn" class="mt-6 bg-green-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-600">OK</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    let gradesData = [];
    let currentGradeForModal = null;
    let isEditMode = false;
    let editingGradeId = null;

    // --- Element Selectors ---
    const subjectSelect = document.getElementById('subject-select');
    const gradeInputs = document.querySelectorAll('.grade-input');
    const addGradeBtn = document.getElementById('add-grade-btn');
    const existingGradesContainer = document.getElementById('existing-grades-container');
    const searchInput = document.getElementById('search-input');
    const totalWeightSpan = document.getElementById('total-weight');
    const progressCircle = document.getElementById('progress-circle');
    const radius = progressCircle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;
    progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;

    // --- Modals & Panels ---
    const gradeDetailModal = document.getElementById('gradeDetailModal');
    const gradeDetailModalPanel = gradeDetailModal.querySelector('.modal-panel');
    const editConfirmationModal = document.getElementById('editConfirmationModal');
    const editConfirmationModalPanel = editConfirmationModal.querySelector('.modal-panel');
    const successModal = document.getElementById('successModal');
    const successModalPanel = successModal.querySelector('.modal-panel');
    
    // --- Helper Functions ---
    const showModal = (modal, panel) => {
        modal.classList.remove('hidden');
        setTimeout(() => panel.classList.remove('opacity-0', 'scale-95'), 10);
    };

    const hideModal = (modal, panel) => {
        panel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    };

    const showSuccessMessage = (title, message) => {
        document.getElementById('successModalTitle').textContent = title;
        document.getElementById('successModalMessage').textContent = message;
        showModal(successModal, successModalPanel);
    };
    
    // --- Core Logic ---
    const updateFormState = () => {
        const total = Array.from(gradeInputs).reduce((sum, input) => sum + (Number(input.value) || 0), 0);
        totalWeightSpan.textContent = `${total}%`;
        
        const offset = circumference - (Math.min(total, 100) / 100) * circumference;
        progressCircle.style.strokeDashoffset = offset;
        
        progressCircle.classList.toggle('text-red-500', total !== 100);
        progressCircle.classList.toggle('text-indigo-500', total === 100);

        const isSubjectSelected = !!subjectSelect.value;
        
        if (isEditMode) {
            addGradeBtn.disabled = total !== 100;
        } else {
            addGradeBtn.disabled = total !== 100 || !isSubjectSelected;
        }
    };

    const resetForm = () => {
        document.getElementById('grade-setup-form').reset();
        subjectSelect.value = '';
        subjectSelect.disabled = false;
        isEditMode = false;
        editingGradeId = null;
        addGradeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" /></svg> Set Grade Scheme`;
        updateFormState();
    };

    const createGradeCard = (grade) => {
        if (!grade.subject) return null;
        
        const card = document.createElement('div');
        card.className = 'grade-card bg-white p-4 rounded-lg shadow-md border border-gray-200 hover:shadow-lg hover:border-indigo-500 transition-all cursor-pointer';
        card.dataset.grade = JSON.stringify(grade);
        const date = new Date(grade.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        
        card.innerHTML = `
            <div class="flex justify-between items-start w-full">
                <div>
                    <p class="font-bold text-indigo-600">${grade.subject.subject_code}</p>
                    <p class="text-sm text-gray-600">${grade.subject.subject_name}</p>
                </div>
                <p class="text-xs text-gray-400 mt-1 self-end">Set: ${date}</p>
            </div>`;
        return card;
    };
    
    const renderGrades = (grades) => {
        existingGradesContainer.innerHTML = '';
        gradesData = grades;
        const existingSubjectIds = new Set(grades.map(g => g.subject_id));

        if (grades.length === 0) {
            existingGradesContainer.innerHTML = '<p class="text-center text-gray-500 py-8">No grade schemes set.</p>';
        } else {
            grades.forEach(grade => {
                const card = createGradeCard(grade);
                if (card) existingGradesContainer.appendChild(card);
            });
        }
        
        Array.from(subjectSelect.options).forEach(option => {
            if (option.value) {
                option.disabled = isEditMode ? (option.value != subjectSelect.value) : existingSubjectIds.has(parseInt(option.value));
            }
        });

        if (!isEditMode && subjectSelect.value && existingSubjectIds.has(parseInt(subjectSelect.value))) {
            subjectSelect.value = '';
        }
        updateFormState();
    };

    // --- API Calls ---
    const fetchAPI = async (url, options = {}) => {
        try {
            const defaultHeaders = { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' };
            options.headers = { ...defaultHeaders, ...options.headers };
            const response = await fetch(url, options);
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'An API error occurred.');
            }
            return response.json();
        } catch (error) {
            console.error('API Fetch Error:', error);
            alert(`Error: ${error.message}`);
            throw error;
        }
    };

    const fetchGrades = () => fetchAPI('/api/grades').then(renderGrades);
    const fetchAndPopulateSubjects = () => {
        fetchAPI('/api/subjects').then(subjects => {
            subjectSelect.innerHTML = '<option value="" disabled selected>Select a Subject</option>';
            subjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.id; 
                option.textContent = `${subject.subject_name} (${subject.subject_code})`;
                subjectSelect.appendChild(option);
            });
            
            const urlParams = new URLSearchParams(window.location.search);
            const subjectId = urlParams.get('subjectId');
            if (subjectId) {
                subjectSelect.value = subjectId;
            }

        }).catch(() => subjectSelect.innerHTML = '<option value="">Could not load subjects</option>');
    };
    
    const submitGrade = async () => {
        const gradePayload = {
            subject_id: subjectSelect.value, 
            aae: document.getElementById('aae-input').value,
            evaluation: document.getElementById('evaluation-input').value,
            assignment: document.getElementById('assignment-input').value,
            exam: document.getElementById('exam-input').value
        };

        const url = isEditMode ? `/api/grades/${editingGradeId}` : '/api/grades';
        const method = isEditMode ? 'PUT' : 'POST';

        try {
            await fetchAPI(url, { method, body: JSON.stringify(gradePayload) });
            await fetchGrades();
            showSuccessMessage(isEditMode ? 'Scheme Updated' : 'Scheme Set', `Grade scheme has been ${isEditMode ? 'updated' : 'set'} successfully.`);
            resetForm();
        } catch (error) { /* Error is handled in fetchAPI */ }
    };
    
    // --- Event Listeners ---
    gradeInputs.forEach(input => input.addEventListener('input', updateFormState));
    subjectSelect.addEventListener('change', updateFormState);
    addGradeBtn.addEventListener('click', ()=>{
        Swal.fire({
            title: 'Are you sure to the grade setup?',
            showDenyButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.isConfirmed) {
                submitGrade().then(()=>{
                    Swal.fire('You successfully setup the grade on the subject', '', 'success').then(
                        ()=>window.location.href = '/subject_mapping'
                    );
                })
            }
        })
    });

    // Card click to open detail modal
    existingGradesContainer.addEventListener('click', (e) => {
        const card = e.target.closest('.grade-card');
        if (card) {
            currentGradeForModal = JSON.parse(card.dataset.grade);
            const { subject, aae, evaluation, assignment, exam } = currentGradeForModal;
            
            document.getElementById('modalSubjectTitle').textContent = subject.subject_name;
            document.getElementById('modalSubjectCode').textContent = subject.subject_code;
            document.getElementById('modalAae').textContent = `${aae}%`;
            document.getElementById('modalEvaluation').textContent = `${evaluation}%`;
            document.getElementById('modalAssignment').textContent = `${assignment}%`;
            document.getElementById('modalExam').textContent = `${exam}%`;
            document.getElementById('modalTotal').textContent = `${aae + evaluation + assignment + exam}%`;
            
            showModal(gradeDetailModal, gradeDetailModalPanel);
        }
    });
    
    // Modal buttons
    document.getElementById('closeDetailModalBtn').addEventListener('click', () => hideModal(gradeDetailModal, gradeDetailModalPanel));
    document.getElementById('closeSuccessModalBtn').addEventListener('click', () => hideModal(successModal, successModalPanel));
    document.getElementById('cancelEditBtn').addEventListener('click', () => hideModal(editConfirmationModal, editConfirmationModalPanel));

    document.getElementById('editGradeBtn').addEventListener('click', () => {
        hideModal(gradeDetailModal, gradeDetailModalPanel);
        setTimeout(() => showModal(editConfirmationModal, editConfirmationModalPanel), 250);
    });

    document.getElementById('confirmEditBtn').addEventListener('click', () => {
        if (!currentGradeForModal) return;

        hideModal(editConfirmationModal, editConfirmationModalPanel);
        
        isEditMode = true;
        editingGradeId = currentGradeForModal.id;

        subjectSelect.value = currentGradeForModal.subject_id;
        document.getElementById('aae-input').value = currentGradeForModal.aae;
        document.getElementById('evaluation-input').value = currentGradeForModal.evaluation;
        document.getElementById('assignment-input').value = currentGradeForModal.assignment;
        document.getElementById('exam-input').value = currentGradeForModal.exam;

        subjectSelect.disabled = true;
        renderGrades(gradesData); // Re-render to handle dropdown options
        addGradeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg> Update Scheme`;
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.grade-card').forEach(card => {
            const grade = JSON.parse(card.dataset.grade);
            const name = grade.subject.subject_name.toLowerCase();
            const code = grade.subject.subject_code.toLowerCase();
            card.style.display = (name.includes(searchTerm) || code.includes(searchTerm)) ? 'flex' : 'none';
        });
    });
    
    // --- Initial Page Load ---
    const initializePage = async () => {
        await fetchAndPopulateSubjects();
        await fetchGrades();
        updateFormState();
    };

    initializePage();
});
</script>
@endsection