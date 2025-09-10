@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    <!-- Main Content Start -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 bg-white p-8 rounded-2xl shadow-lg">
            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">Grade Weighting Setup</h1>
                <p class="mt-1 text-sm text-gray-500">Configure grade computation and weighting schemes</p>
            </div>
            
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-800">Weighting Configuration</h2>
                <div class="space-y-6 mt-4">
                    <div>
                        <label for="subject-select" class="block text-sm font-medium text-gray-700">Subject/Course</label>
                        <select id="subject-select" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="COMPROG1">Computer Programming 1 - COMPROG1</option>
                            <option value="DBMS101">Database Management System - DBMS101</option>
                            <option value="OOP201">Object-Oriented Programming - OOP201</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <h2 class="text-xl font-semibold text-gray-800">Grade Components</h2>
                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">AAE</label>
                        <input type="number" id="aae-input" value="20" class="grade-input mt-1 text-center block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Evaluation</label>
                        <input type="number" id="evaluation-input" value="20" class="grade-input mt-1 text-center block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Assignment</label>
                        <input type="number" id="assignment-input" value="20" class="grade-input mt-1 text-center block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Exam</label>
                        <input type="number" id="exam-input" value="40" class="grade-input mt-1 text-center block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
                <div class="mt-6 bg-gray-50 p-4 rounded-lg flex justify-between items-center">
                    <span class="font-semibold text-gray-800">Total Weight:</span>
                    <span id="total-weight" class="font-bold text-xl text-gray-900">100%</span>
                </div>
            </div>

            <div class="mt-10">
                <button id="add-grade-btn" class="w-full bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                    Add Grade
                </button>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- New Existing Subjects Grade section with search bar -->
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Existing Subjects Grade</h2>
                    <input type="text" id="search-input" placeholder="Search..." class="mt-4 sm:mt-0 w-full sm:w-auto py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>
                <div id="existing-grades-container" class="space-y-4 max-h-96 overflow-y-auto">
                    <!-- Dynamic content will be added here -->
                    <p class="text-center text-gray-500">No grades added yet.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content End -->
</main>

<!-- Modal for displaying grade details -->
<div id="gradeDetailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-lg mx-4">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h3 class="text-2xl font-bold text-gray-900" id="modalSubjectTitle"></h3>
            <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="space-y-4">
            <p class="text-gray-700"><span class="font-semibold">AAE:</span> <span id="modalAae"></span></p>
            <p class="text-gray-700"><span class="font-semibold">Evaluation:</span> <span id="modalEvaluation"></span></p>
            <p class="text-gray-700"><span class="font-semibold">Assignment:</span> <span id="modalAssignment"></span></p>
            <p class="text-gray-700"><span class="font-semibold">Exam:</span> <span id="modalExam"></span></p>
            <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center mt-4">
                <span class="font-semibold text-gray-800">Final Grade:</span>
                <span class="font-bold text-xl text-gray-900" id="modalFinalGrade"></span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Grade component weights (as decimals)
    const weights = {
        aae: 0.20,
        evaluation: 0.20,
        assignment: 0.20,
        exam: 0.40
    };

    // Store grade data
    const gradesData = [];
    let currentId = 0;

    // Get DOM elements
    const subjectSelect = document.getElementById('subject-select');
    const aaeInput = document.getElementById('aae-input');
    const evaluationInput = document.getElementById('evaluation-input');
    const assignmentInput = document.getElementById('assignment-input');
    const examInput = document.getElementById('exam-input');
    const addGradeBtn = document.getElementById('add-grade-btn');
    const existingGradesContainer = document.getElementById('existing-grades-container');
    const searchInput = document.getElementById('search-input');
    const totalWeightSpan = document.getElementById('total-weight');

    // Modal elements
    const gradeDetailModal = document.getElementById('gradeDetailModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modalSubjectTitle = document.getElementById('modalSubjectTitle');
    const modalAae = document.getElementById('modalAae');
    const modalEvaluation = document.getElementById('modalEvaluation');
    const modalAssignment = document.getElementById('modalAssignment');
    const modalExam = document.getElementById('modalExam');
    const modalFinalGrade = document.getElementById('modalFinalGrade');


    // Function to calculate final grade as a percentage
    const calculateFinalGrade = (grades) => {
        // Calculate the percentage score based on weighted inputs
        const totalScore = (grades.aae * weights.aae) +
                           (grades.evaluation * weights.evaluation) +
                           (grades.assignment * weights.assignment) +
                           (grades.exam * weights.exam);

        return totalScore.toFixed(2);
    };

    // Function to update total weight display
    const updateTotalWeight = () => {
        const aae = parseFloat(aaeInput.value) || 0;
        const evaluation = parseFloat(evaluationInput.value) || 0;
        const assignment = parseFloat(assignmentInput.value) || 0;
        const exam = parseFloat(examInput.value) || 0;

        const total = aae + evaluation + assignment + exam;
        totalWeightSpan.textContent = `${total}%`;
    };

    // Add event listeners to grade input fields to update total weight
    document.querySelectorAll('.grade-input').forEach(input => {
        input.addEventListener('input', updateTotalWeight);
    });

    // Function to add a new grade entry
    const addGradeEntry = () => {
        const subject = subjectSelect.options[subjectSelect.selectedIndex].text;
        const grades = {
            id: currentId++,
            subject: subject,
            aae: parseFloat(aaeInput.value) || 0,
            evaluation: parseFloat(evaluationInput.value) || 0,
            assignment: parseFloat(assignmentInput.value) || 0,
            exam: parseFloat(examInput.value) || 0,
            finalGrade: calculateFinalGrade({
                aae: parseFloat(aaeInput.value) || 0,
                evaluation: parseFloat(evaluationInput.value) || 0,
                assignment: parseFloat(assignmentInput.value) || 0,
                exam: parseFloat(examInput.value) || 0
            }),
            date: new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
        };

        // Store the grade data
        gradesData.push(grades);

        const gradeHtml = `
            <div class="p-4 border border-gray-200 rounded-lg flex justify-between items-center transition-shadow hover:shadow-md cursor-pointer" data-id="${grades.id}">
                <div>
                    <h3 class="font-bold text-gray-900">${grades.subject}</h3>
                </div>
                <p class="text-sm text-gray-500">${grades.date}</p>
            </div>
        `;

        // Check for placeholder and remove it
        const placeholder = existingGradesContainer.querySelector('p');
        if (placeholder && placeholder.textContent.includes('No grades added yet.')) {
            existingGradesContainer.innerHTML = '';
        }

        existingGradesContainer.innerHTML += gradeHtml;
    };

    // Function to display the modal
    const showGradeModal = (grade) => {
        modalSubjectTitle.textContent = grade.subject;
        modalAae.textContent = grade.aae;
        modalEvaluation.textContent = grade.evaluation;
        modalAssignment.textContent = grade.assignment;
        modalExam.textContent = grade.exam;
        
        // Final grade is now a sum of component values
        const finalGradeValue = parseFloat(grade.aae) + parseFloat(grade.evaluation) + parseFloat(grade.assignment) + parseFloat(grade.exam);
        modalFinalGrade.textContent = `${finalGradeValue}%`;

        gradeDetailModal.classList.remove('hidden');
    };

    // Function to hide the modal
    const hideGradeModal = () => {
        gradeDetailModal.classList.add('hidden');
    };

    // Event listener for the "Add Grade" button
    addGradeBtn.addEventListener('click', addGradeEntry);

    // Event listener for double-clicking a grade entry
    existingGradesContainer.addEventListener('dblclick', (e) => {
        const gradeEntry = e.target.closest('[data-id]');
        if (gradeEntry) {
            const gradeId = parseInt(gradeEntry.dataset.id, 10);
            const grade = gradesData.find(g => g.id === gradeId);
            if (grade) {
                showGradeModal(grade);
            }
        }
    });

    // Event listener for closing the modal
    closeModalBtn.addEventListener('click', hideGradeModal);
    gradeDetailModal.addEventListener('click', (e) => {
        if (e.target === gradeDetailModal) {
            hideGradeModal();
        }
    });

    // Filter grades based on search input
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const allGrades = existingGradesContainer.querySelectorAll('[data-id]');

        allGrades.forEach(gradeEntry => {
            const subjectName = gradeEntry.querySelector('h3').textContent.toLowerCase();
            if (subjectName.includes(searchTerm)) {
                gradeEntry.style.display = 'flex';
            } else {
                gradeEntry.style.display = 'none';
            }
        });
    });

    // Initial total weight calculation on page load
    updateTotalWeight();
});
</script>
@endsection
