@extends('layouts.app')

@section('content')
<style>
    /* Custom styles for the progress circle and other enhancements */
    .progress-ring__circle {
        transition: stroke-dashoffset 0.35s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
</style>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 sm:p-6 md:p-8">
    <div class="container mx-auto">

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <div class="lg:col-span-2 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-2xl shadow-lg border border-gray-200/80">
                <form id="grade-setup-form">
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
                                    <option>Loading subjects...</option>
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
            
            <div class="lg:col-span-1 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-2xl shadow-lg border border-gray-200/80">
                <h2 class="text-xl font-bold text-gray-700 mb-4 pb-3 border-b">Grading Scale</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3">Description</th>
                                <th scope="col" class="px-4 py-3">Numerical</th>
                                <th scope="col" class="px-4 py-3">Percentage</th>
                            </tr>
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
    </div>
</main>

<div id="gradeDetailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-2xl w-full max-w-lg mx-4 transform scale-95 opacity-0 transition-all border border-gray-200/80">
        <div class="flex justify-between items-start pb-4 mb-6 border-b border-gray-200"><div class="flex items-center gap-4"><div class="w-12 h-12 flex-shrink-0 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg></div><div><h3 class="text-xl font-bold text-gray-800" id="modalSubjectTitle"></h3><p class="text-sm text-gray-500" id="modalSubjectCode"></p></div></div><button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button></div>
        <div class="space-y-3 text-base">
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border"><span class="font-semibold text-gray-600">AAE:</span> <span id="modalAae" class="font-bold text-gray-800 text-lg"></span></div>
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border"><span class="font-semibold text-gray-600">Evaluation:</span> <span id="modalEvaluation" class="font-bold text-gray-800 text-lg"></span></div>
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border"><span class="font-semibold text-gray-600">Assignment:</span> <span id="modalAssignment" class="font-bold text-gray-800 text-lg"></span></div>
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border"><span class="font-semibold text-gray-600">Exam:</span> <span id="modalExam" class="font-bold text-gray-800 text-lg"></span></div>
            <div class="flex justify-between items-center p-4 bg-indigo-50 rounded-lg border border-indigo-200"><span class="font-semibold text-indigo-600">Total Grade:</span> <span id="modalTotal" class="font-bold text-indigo-800 text-lg"></span></div>
        </div>
        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end"><button id="editGradeSchemeBtn" type="button" class="flex items-center justify-center gap-2 bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-all duration-300 border border-gray-300 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>Edit Scheme</button></div>
    </div>
</div>

<div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm mx-4 text-center transform scale-95 opacity-0 transition-all border border-gray-200/80">
        <div class="w-16 h-16 rounded-full bg-emerald-100 p-2 flex items-center justify-center mx-auto mb-4"><svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
        <h3 class="text-2xl font-bold text-gray-800">Success!</h3>
        <p class="text-gray-500 mt-2">The grade scheme has been set for the subject.</p>
        <button id="closeSuccessModalBtn" class="mt-6 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">OK</button>
    </div>
</div>

<div id="editConfirmationModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm mx-4 text-center transform scale-95 opacity-0 transition-all border border-gray-200/80">
        <div class="w-16 h-16 rounded-full bg-amber-100 p-2 flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688 0-1.25-.563-1.25-1.25s.563-1.25 1.25-1.25c.688 0 1.25.563 1.25 1.25s-.563 1.25-1.25 1.25z" /><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 11.25c-.688 0-1.25-.563-1.25-1.25V6.25c0-.688.563-1.25 1.25-1.25s1.25.563 1.25 1.25v3.75c0 .688-.563 1.25-1.25 1.25z" /><path stroke-linecap="round" stroke-linejoin="round" d="M18.813 18.813c3.75-3.75 3.75-9.813 0-13.563s-9.813-3.75-13.563 0c-3.75 3.75-3.75 9.813 0 13.563s9.813 3.75 13.563 0z" /></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800">Confirm Edit</h3>
        <p class="text-gray-500 mt-2">Are you sure you want to edit this grade scheme? The current values in the form will be updated.</p>
        <div class="mt-6 flex justify-center gap-3">
             <button id="cancelEditBtn" class="w-full bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-all duration-300 border border-gray-300">Cancel</button>
             <button id="confirmEditBtn" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300">Yes, Edit</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let gradesData = [];
    let currentGradeForModal = null;
    let existingGradeCodes = new Set();

    const subjectSelect = document.getElementById('subject-select');
    const aaeInput = document.getElementById('aae-input');
    const evaluationInput = document.getElementById('evaluation-input');
    const assignmentInput = document.getElementById('assignment-input');
    const examInput = document.getElementById('exam-input');
    const addGradeBtn = document.getElementById('add-grade-btn');
    const existingGradesContainer = document.getElementById('existing-grades-container');
    const searchInput = document.getElementById('search-input');
    const totalWeightSpan = document.getElementById('total-weight');
    const progressCircle = document.getElementById('progress-circle');
    const radius = progressCircle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;
    progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
    progressCircle.style.strokeDashoffset = 0;
    
    // Modals
    const gradeDetailModal = document.getElementById('gradeDetailModal');
    const gradeDetailModalPanel = gradeDetailModal.querySelector('.transform');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const successModal = document.getElementById('successModal');
    const successModalPanel = successModal.querySelector('.transform');
    const closeSuccessModalBtn = document.getElementById('closeSuccessModalBtn');
    const editConfirmationModal = document.getElementById('editConfirmationModal');
    const editConfirmationModalPanel = editConfirmationModal.querySelector('.transform');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const confirmEditBtn = document.getElementById('confirmEditBtn');

    // Modal Content
    const modalSubjectTitle = document.getElementById('modalSubjectTitle');
    const modalSubjectCode = document.getElementById('modalSubjectCode');
    const modalAae = document.getElementById('modalAae');
    const modalEvaluation = document.getElementById('modalEvaluation');
    const modalAssignment = document.getElementById('modalAssignment');
    const modalExam = document.getElementById('modalExam');
    const modalTotal = document.getElementById('modalTotal');
    const editGradeSchemeBtn = document.getElementById('editGradeSchemeBtn');

    const createGradeCard = (grade) => {
        const gradeCard = document.createElement('div');
        gradeCard.className = 'grade-item overflow-hidden p-3 bg-white border border-gray-200 rounded-lg flex justify-between items-center transition-all hover:shadow-lg hover:border-indigo-500 cursor-pointer';
        gradeCard.dataset.id = grade.id;
        const date = new Date(grade.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        gradeCard.innerHTML = `<div class="flex items-center gap-3"><div class="w-10 h-10 flex-shrink-0 bg-gray-100 rounded-md flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg></div><div><h3 class="font-semibold text-gray-800">${grade.subject_name}</h3><p class="text-xs text-gray-500">${grade.subject_code}</p></div></div><span class="text-xs text-gray-400 font-medium">${date}</span>`;
        return gradeCard;
    };
    
    const renderGrades = (grades) => {
        existingGradesContainer.innerHTML = '';
        gradesData = grades;
        existingGradeCodes = new Set(grades.map(g => g.subject_code));
        if (grades.length === 0) {
            existingGradesContainer.innerHTML = '<p class="text-center text-gray-500 py-8">No grade schemes have been set yet.</p>';
        } else {
            grades.forEach(grade => {
                existingGradesContainer.appendChild(createGradeCard(grade));
            });
        }
        updateFormState(subjectSelect.value);
    };

    const updateTotalWeight = () => {
        const total = (parseFloat(aaeInput.value) || 0) + (parseFloat(evaluationInput.value) || 0) + (parseFloat(assignmentInput.value) || 0) + (parseFloat(examInput.value) || 0);
        totalWeightSpan.textContent = `${total}%`;
        const offset = circumference - (Math.min(total, 100) / 100) * circumference;
        progressCircle.style.strokeDashoffset = offset;
        progressCircle.classList.toggle('text-red-500', total !== 100);
        progressCircle.classList.toggle('text-indigo-500', total === 100);
    };

    const showModal = (modal, panel) => {
        modal.classList.remove('hidden');
        setTimeout(() => { panel.classList.remove('opacity-0', 'scale-95'); }, 10);
    };

    const hideModal = (modal, panel) => {
        panel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    };

    const fetchGrades = async () => {
        try {
            const response = await fetch('/api/grades');
            if (!response.ok) throw new Error('Failed to fetch grades.');
            const grades = await response.json();
            renderGrades(grades);
        } catch (error) {
            console.error(error);
            existingGradesContainer.innerHTML = '<p class="text-center text-red-500">Could not load existing grades.</p>';
        }
    };

    const fetchAndPopulateSubjects = async () => {
        try {
            const response = await fetch('/api/subjects');
            const subjects = await response.json();
            subjectSelect.innerHTML = '<option value="" disabled selected>Select a Subject</option>';
            subjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.subject_code;
                option.textContent = `${subject.subject_name} - ${subject.subject_code}`;
                option.dataset.name = subject.subject_name;
                subjectSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Failed to fetch subjects:', error);
            subjectSelect.innerHTML = '<option>Could not load subjects</option>';
        }
    };
    
    const updateFormState = (subjectCode) => {
        if (existingGradeCodes.has(subjectCode)) {
            addGradeBtn.disabled = true;
            addGradeBtn.textContent = 'Scheme Already Set';
        } else {
            addGradeBtn.disabled = false;
            addGradeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" /></svg> Set Grade Scheme`;
        }
    };

    const addGradeEntry = async () => {
        const selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
        if (!selectedOption || !selectedOption.value) {
            alert('Please select a subject.'); return;
        }

        const gradePayload = { subject_code: selectedOption.value, subject_name: selectedOption.dataset.name, aae: parseInt(aaeInput.value, 10), evaluation: parseInt(evaluationInput.value, 10), assignment: parseInt(assignmentInput.value, 10), exam: parseInt(examInput.value, 10) };

        try {
            const response = await fetch('/api/grades', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' },
                body: JSON.stringify(gradePayload)
            });
            if (!response.ok) {
                const errorData = await response.json();
                let errorMessage = errorData.message || 'An unknown server error occurred.';
                if (errorData.errors) { errorMessage = Object.values(errorData.errors).map(e => e.join('\n')).join('\n'); }
                throw new Error(errorMessage);
            }
            await fetchGrades();
            showModal(successModal, successModalPanel);
        } catch (error) {
            console.error('Error details:', error);
            alert(error.message || 'An error occurred while saving the grade.');
        }
    };
    
    // --- EVENT LISTENERS ---
    document.querySelectorAll('.grade-input').forEach(input => input.addEventListener('input', updateTotalWeight));
    addGradeBtn.addEventListener('click', addGradeEntry);
    subjectSelect.addEventListener('change', (e) => updateFormState(e.target.value));

    // Modal Event Listeners
    closeSuccessModalBtn.addEventListener('click', () => hideModal(successModal, successModalPanel));
    closeModalBtn.addEventListener('click', () => hideModal(gradeDetailModal, gradeDetailModalPanel));
    cancelEditBtn.addEventListener('click', () => hideModal(editConfirmationModal, editConfirmationModalPanel));

    existingGradesContainer.addEventListener('dblclick', (e) => {
        const gradeEntry = e.target.closest('[data-id]');
        if (gradeEntry) {
            const gradeId = parseInt(gradeEntry.dataset.id, 10);
            const grade = gradesData.find(g => g.id === gradeId);
            if (grade) {
                currentGradeForModal = grade;
                modalSubjectTitle.textContent = grade.subject_name;
                modalSubjectCode.textContent = grade.subject_code;
                modalAae.textContent = `${grade.aae}%`;
                modalEvaluation.textContent = `${grade.evaluation}%`;
                modalAssignment.textContent = `${grade.assignment}%`;
                modalExam.textContent = `${grade.exam}%`;
                const total = grade.aae + grade.evaluation + grade.assignment + grade.exam;
                modalTotal.textContent = `${total}%`;
                showModal(gradeDetailModal, gradeDetailModalPanel);
            }
        }
    });

    editGradeSchemeBtn.addEventListener('click', () => {
        if (currentGradeForModal) {
            hideModal(gradeDetailModal, gradeDetailModalPanel);
            setTimeout(() => showModal(editConfirmationModal, editConfirmationModalPanel), 350);
        }
    });

    confirmEditBtn.addEventListener('click', () => {
        if (!currentGradeForModal) return;
        subjectSelect.value = currentGradeForModal.subject_code;
        aaeInput.value = currentGradeForModal.aae;
        evaluationInput.value = currentGradeForModal.evaluation;
        assignmentInput.value = currentGradeForModal.assignment;
        examInput.value = currentGradeForModal.exam;

        updateTotalWeight();
        addGradeBtn.disabled = false;
        addGradeBtn.textContent = 'Update Grade Scheme';
        hideModal(editConfirmationModal, editConfirmationModalPanel);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        existingGradesContainer.querySelectorAll('.grade-item').forEach(item => {
            item.style.display = item.textContent.toLowerCase().includes(searchTerm) ? 'flex' : 'none';
        });
    });
    
    // --- INITIAL PAGE LOAD ---
    const initializePage = async () => {
        await fetchAndPopulateSubjects();
        await fetchGrades();
        const urlParams = new URLSearchParams(window.location.search);
        const subjectIdParam = urlParams.get('subjectId');
        if (subjectIdParam) {
            try {
                const response = await fetch(`/api/subjects/${subjectIdParam}`);
                const subject = await response.json();
                if (subject && subject.subject_code) {
                    subjectSelect.value = subject.subject_code;
                    updateFormState(subject.subject_code);
                }
            } catch (error) {
                console.error('Error fetching specific subject:', error);
            }
        }
    };

    updateTotalWeight();
    initializePage();
});
</script>
@endsection