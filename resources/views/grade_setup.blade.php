@extends('layouts.app')

@section('content')
<style>
    .progress-ring__circle { transition: stroke-dashoffset 0.35s; transform: rotate(-90deg); transform-origin: 50% 50%; }
    .accordion-content { max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; }
    .component-row input { background-color: #f8fafc; }
    .component-row:hover input { background-color: #f1f5f9; }
</style>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 sm:p-6 md:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Grade Scheme Setup Form --}}
        <div class="lg:col-span-2 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-2xl shadow-lg border border-gray-200/80">
            <form id="grade-setup-form" onsubmit="return false;">
                @csrf
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Grade Scheme Setup</h1>
                    <p class="text-sm text-gray-600 mt-1">Design and manage grading component weights for subjects.</p>
                </div>

                {{-- Subject Selection --}}
                <div class="border border-gray-200 bg-gray-50/50 p-6 rounded-xl">
                    <div class="flex items-center gap-3 pb-3 mb-4">
                        <div class="w-10 h-10 flex-shrink-0 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" /></svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-700">Select Subject</h2>
                    </div>
                    <div>
                        <label for="subject-select" class="block text-sm font-medium text-gray-600 mb-1">Subject / Course</label>
                        <select id="subject-select" class="w-full py-3 pl-4 pr-10 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm transition-colors">
                            <option value="">Loading subjects...</option>
                        </select>
                    </div>
                </div>

                {{-- Grade Components --}}
                <div class="mt-8">
                    <div class="flex items-center gap-3 pb-3 mb-6">
                       <div class="w-10 h-10 flex-shrink-0 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M12 21a9 9 0 110-18 9 9 0 010 18z" /></svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-700">Semestral Grade Components</h2>
                    </div>

                    <div class="space-y-4" id="semestral-grade-accordion">
                        @include('partials.grade_component_table', ['period' => 'prelim', 'weight' => 30])
                        @include('partials.grade_component_table', ['period' => 'midterm', 'weight' => 30])
                        @include('partials.grade_component_table', ['period' => 'finals', 'weight' => 40])
                    </div>

                    <div class="mt-8 flex justify-center items-center p-4 bg-gray-100 rounded-lg border border-gray-200">
                        <div class="relative w-24 h-24">
                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                <circle class="text-gray-200" stroke-width="10" stroke="currentColor" fill="transparent" r="45" cx="50" cy="50" />
                                <circle id="progress-circle" class="progress-ring__circle text-indigo-500" stroke-width="10" stroke-linecap="round" stroke="currentColor" fill="transparent" r="45" cx="50" cy="50" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span id="total-weight" class="text-2xl font-bold text-gray-700">100%</span>
                            </div>
                        </div>
                        <p class="ml-4 font-semibold text-gray-600">Total Weight</p>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-200">
                    <button id="add-grade-btn" type="button" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 text-white font-bold py-3 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6a1 1 0 10-2 0v5.586L7.707 10.293zM10 18a8 8 0 100-16 8 8 0 000 16z" /></svg>
                        Set Grade Scheme
                    </button>
                </div>
            </form>
        </div>

        {{-- Right Side Panel (e.g., Grading Scale) --}}
        <div class="lg:col-span-1 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-2xl shadow-lg border border-gray-200/80">
            <h2 class="text-xl font-bold text-gray-700 mb-4 pb-3 border-b">Grading Scale</h2>
            {{-- Placeholder for your grading scale table or other content --}}
            <p class="text-gray-600">Your grading scale information can be displayed here.</p>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- STATE & CONFIG ---
    let subjects = [];
    const defaultStructure = {
        prelim: { weight: 30, components: [ { name: "Class Standing", weight: 40, sub_components: [ { name: "Attendance", weight: 10 }, { name: "Written Works", weight: 50 }, { name: "Performance Task", weight: 40 } ] }, { name: "Project", weight: 25, sub_components: [ { name: "Course-Based Output", weight: 100 } ] }, { name: "Examination", weight: 35, sub_components: [ { name: "Written Examination", weight: 100 } ] } ] },
        midterm: { weight: 30, components: [ { name: "Class Standing", weight: 40, sub_components: [ { name: "Attendance", weight: 10 }, { name: "Written Works", weight: 50 }, { name: "Performance Task", weight: 40 } ] }, { name: "Project", weight: 25, sub_components: [ { name: "Course-Based Output", weight: 100 } ] }, { name: "Examination", weight: 35, sub_components: [ { name: "Written Examination", weight: 100 } ] } ] },
        finals: { weight: 40, components: [ { name: "Class Standing", weight: 40, sub_components: [ { name: "Attendance", weight: 10 }, { name: "Written Works", weight: 50 }, { name: "Performance Task", weight: 40 } ] }, { name: "Project", weight: 25, sub_components: [ { name: "Course-Based Output", weight: 100 } ] }, { name: "Examination", weight: 35, sub_components: [ { name: "Written Examination", weight: 100 } ] } ] }
    };

    // --- ELEMENT SELECTORS ---
    const accordionContainer = document.getElementById('semestral-grade-accordion');
    const totalWeightSpan = document.getElementById('total-weight');
    const progressCircle = document.getElementById('progress-circle');
    const addGradeBtn = document.getElementById('add-grade-btn');
    const subjectSelect = document.getElementById('subject-select');

    // --- TEMPLATE FUNCTIONS ---
    const createRow = (isSub, period, component = { name: '', weight: 0 }) => {
        const tr = document.createElement('tr');
        tr.className = `component-row ${isSub ? 'sub-component-row' : 'main-component-row'}`;
        const namePlaceholder = isSub ? "Sub-component Name" : "Main Component Name";
        const inputClass = isSub ? 'sub-input' : 'main-input';
        
        tr.innerHTML = `
            <td class="p-2 ${isSub ? 'pl-8' : 'pl-4'}">
                <input type="text" placeholder="${namePlaceholder}" value="${component.name}" class="component-name-input w-full border-0 focus:ring-0 p-1 rounded">
            </td>
            <td class="p-2">
                <input type="number" value="${component.weight}" class="${inputClass} w-full text-center font-bold border-gray-300 rounded-md p-1">
            </td>
            <td class="p-2 text-center">
                ${!isSub ? `<button type="button" class="add-sub-btn text-blue-500 hover:text-blue-700 p-1" title="Add Sub-component">➕</button>` : ''}
                <button type="button" class="remove-row-btn text-red-500 hover:text-red-700 p-1" title="Remove Row">🗑️</button>
            </td>
        `;
        return tr;
    };

    // --- EVENT HANDLERS & LOGIC ---
    const handleDynamicEvents = (e) => {
        const target = e.target;
        if (target.classList.contains('add-component-btn')) {
            const tbody = target.closest('.accordion-content').querySelector('.component-tbody');
            tbody.appendChild(createRow(false, tbody.closest('.period-container').dataset.period));
        } else if (target.closest('.add-sub-btn')) {
            const parentRow = target.closest('tr');
            const newSubRow = createRow(true, parentRow.closest('.period-container').dataset.period);
            parentRow.insertAdjacentElement('afterend', newSubRow);
        } else if (target.closest('.remove-row-btn')) {
            const rowToRemove = target.closest('tr');
            // If it's a main row, also remove its sub-components
            if (rowToRemove.classList.contains('main-component-row')) {
                let nextRow = rowToRemove.nextElementSibling;
                while (nextRow && nextRow.classList.contains('sub-component-row')) {
                    const toRemove = nextRow;
                    nextRow = nextRow.nextElementSibling;
                    toRemove.remove();
                }
            }
            rowToRemove.remove();
        }
        calculateAndUpdateTotals();
    };
    
    // --- CALCULATIONS & VALIDATION ---
    const calculateAndUpdateTotals = () => {
        let semestralTotal = 0;
        document.querySelectorAll('.semestral-input').forEach(input => semestralTotal += Number(input.value) || 0);
        
        totalWeightSpan.textContent = `${semestralTotal}%`;
        const radius = progressCircle.r.baseVal.value;
        const circumference = 2 * Math.PI * radius;
        progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
        const offset = circumference - (Math.min(semestralTotal, 100) / 100) * circumference;
        progressCircle.style.strokeDashoffset = offset;
        progressCircle.classList.toggle('text-red-500', semestralTotal !== 100);
        progressCircle.classList.toggle('text-indigo-500', semestralTotal === 100);

        let allSubTotalsCorrect = true;
        document.querySelectorAll('.period-container').forEach(container => {
            let periodSubTotal = 0;
            container.querySelectorAll('.main-input').forEach(input => periodSubTotal += Number(input.value) || 0);

            const subTotalSpan = container.querySelector('.sub-total');
            subTotalSpan.textContent = `${periodSubTotal}%`;
            subTotalSpan.classList.toggle('text-red-500', periodSubTotal !== 100);
            subTotalSpan.classList.toggle('text-gray-700', periodSubTotal === 100);
            if (periodSubTotal !== 100) allSubTotalsCorrect = false;

            container.querySelectorAll('.main-component-row').forEach(mainRow => {
                let subComponentTotal = 0;
                let nextRow = mainRow.nextElementSibling;
                let hasSubComponents = false;
                while (nextRow && nextRow.classList.contains('sub-component-row')) {
                    hasSubComponents = true;
                    const input = nextRow.querySelector('.sub-input');
                    subComponentTotal += Number(input.value) || 0;
                    nextRow = nextRow.nextElementSibling;
                }
                
                if (hasSubComponents && subComponentTotal !== 100) {
                    mainRow.classList.add('bg-red-100');
                    allSubTotalsCorrect = false;
                } else {
                    mainRow.classList.remove('bg-red-100');
                }
            });
        });

        addGradeBtn.disabled = semestralTotal !== 100 || !allSubTotalsCorrect || !subjectSelect.value;
    };

    // --- DATA HANDLING ---
    const getGradeDataFromDOM = () => {
        const data = {};
        document.querySelectorAll('.period-container').forEach(container => {
            const period = container.dataset.period;
            data[period] = {
                weight: Number(container.querySelector('.semestral-input').value) || 0,
                components: []
            };
            container.querySelectorAll('.main-component-row').forEach(mainRow => {
                const mainComponent = {
                    name: mainRow.querySelector('.component-name-input').value,
                    weight: Number(mainRow.querySelector('.main-input').value) || 0,
                    sub_components: []
                };

                let nextRow = mainRow.nextElementSibling;
                while (nextRow && nextRow.classList.contains('sub-component-row')) {
                    mainComponent.sub_components.push({
                        name: nextRow.querySelector('.component-name-input').value,
                        weight: Number(nextRow.querySelector('.sub-input').value) || 0,
                    });
                    nextRow = nextRow.nextElementSibling;
                }
                data[period].components.push(mainComponent);
            });
        });
        return data;
    };

    const loadGradeDataToDOM = (componentsData) => {
        const dataToLoad = componentsData || defaultStructure;
        
        Object.keys(dataToLoad).forEach(period => {
            const periodData = dataToLoad[period];
            const container = document.querySelector(`.period-container[data-period="${period}"]`);
            if (!container) return;

            container.querySelector('.semestral-input').value = periodData.weight || 0;
            const tbody = container.querySelector('.component-tbody');
            tbody.innerHTML = ''; // Clear existing rows

            periodData.components.forEach(component => {
                const mainRow = createRow(false, period, component);
                tbody.appendChild(mainRow);
                (component.sub_components || []).forEach(sub => {
                    const subRow = createRow(true, period, sub);
                    tbody.appendChild(subRow);
                });
            });
        });
        calculateAndUpdateTotals();
    };

    // --- API CALLS ---
    const fetchAPI = async (url, options = {}) => {
        try {
            options.headers = { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, 'Accept': 'application/json', ...options.headers };
            const response = await fetch(url, options);
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'API Error');
            }
            return response.json();
        } catch (error) {
            Swal.fire('Error', error.message, 'error');
            throw error;
        }
    };
    
    const fetchAndPopulateSubjects = () => {
        fetchAPI('/api/subjects').then(data => {
            subjects = data;
            subjectSelect.innerHTML = '<option value="" disabled selected>Select a Subject</option>';
            subjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.id;
                option.textContent = `${subject.subject_name} (${subject.subject_code})`;
                subjectSelect.appendChild(option);
            });
        });
    };

    const fetchGradeSetupForSubject = (subjectId) => {
        if (!subjectId) {
            loadGradeDataToDOM(defaultStructure);
            return;
        }
        fetchAPI(`/api/grades/${subjectId}`)
            .then(data => loadGradeDataToDOM(data.components))
            .catch(() => loadGradeDataToDOM(defaultStructure));
    };
    
    // --- INITIALIZATION & EVENT LISTENERS ---
    accordionContainer.addEventListener('click', handleDynamicEvents);
    accordionContainer.addEventListener('input', calculateAndUpdateTotals);
    subjectSelect.addEventListener('change', (e) => fetchGradeSetupForSubject(e.target.value));
    
    addGradeBtn.addEventListener('click', () => {
        Swal.fire({
            title: 'Confirm Grade Scheme',
            text: 'Are you sure you want to save this for the selected subject?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#d33',
        }).then(async (result) => {
            if (result.isConfirmed) {
                const payload = {
                    subject_id: subjectSelect.value,
                    components: getGradeDataFromDOM(),
                };
                try {
                    await fetchAPI('/api/grades', { method: 'POST', body: JSON.stringify(payload) });
                    Swal.fire('Saved!', 'The grade scheme has been saved successfully.', 'success');
                } catch(e) { /* Error is handled globally in fetchAPI */ }
            }
        });
    });

    document.querySelectorAll('.accordion-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');
            const isOpen = content.style.maxHeight;
            
            // Close all accordions
            document.querySelectorAll('.accordion-content').forEach(c => c.style.maxHeight = null);
            document.querySelectorAll('.accordion-toggle svg').forEach(i => i.classList.remove('rotate-180'));

            // Open the clicked one if it was closed
            if (!isOpen) {
                content.style.maxHeight = content.scrollHeight + "px";
                icon.classList.add('rotate-180');
            }
        });
    });

    // --- INITIAL LOAD ---
    fetchAndPopulateSubjects();
    loadGradeDataToDOM(defaultStructure);
});
</script>
@endsection