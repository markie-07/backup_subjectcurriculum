@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-8 rounded-2xl shadow-lg">
            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">Curriculum Export Tool</h1>
                <p class="mt-1 text-sm text-gray-500">Select a curriculum and export its data as a PDF.</p>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-800">Export Configuration</h2>
                <div class="space-y-6 mt-4">
                    <div>
                        <label for="curriculum-select" class="block text-sm font-medium text-gray-700">Select Curriculum</label>
                        <select id="curriculum-select" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Please select a curriculum --</option>
                            @foreach($curriculums as $curriculum)
                                <option value="{{ $curriculum->id }}">{{ $curriculum->curriculum }} ({{ $curriculum->program_code }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <button id="export-curriculum-btn" class="w-full bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-300 disabled:opacity-50" disabled>
                    Export Curriculum as PDF
                </button>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b">Export History</h2>
            <div id="export-history" class="space-y-4 max-h-[60vh] overflow-y-auto">
                @forelse ($exportHistories as $history)
                    <div class="flex items-center justify-between p-4 border rounded-lg hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $history->curriculum->curriculum ?? 'Unknown' }}</h3>
                            <p class="text-sm text-gray-500">{{ $history->format }} • {{ $history->created_at->format('M d, Y, g:i A') }}</p>
                        </div>
                        <span class="text-gray-400">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center" id="no-history-msg">No export history yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const exportButton = document.getElementById('export-curriculum-btn');
    const curriculumSelect = document.getElementById('curriculum-select');
    const exportHistoryContainer = document.getElementById('export-history');
    const noHistoryMessage = document.getElementById('no-history-msg');

    curriculumSelect.addEventListener('change', function() {
        exportButton.disabled = !this.value;
    });

    exportButton.addEventListener('click', async function () {
        const curriculumId = curriculumSelect.value;
        if (!curriculumId) {
            alert('Please select a curriculum to export.');
            return;
        }

        try {
            const response = await fetch(`/api/curriculum/${curriculumId}/details`);
            if (!response.ok) throw new Error('Failed to fetch curriculum details.');
            const curriculum = await response.json();
            const fileName = `${curriculum.program_code}_${curriculum.curriculum}.pdf`;
            
            generatePdf(curriculum, fileName);
            
            const newHistory = await saveExportHistory(curriculumId, fileName, 'PDF');
            addHistoryItemToDOM(newHistory);

        } catch (error) {
            console.error('Export Error:', error);
            alert('An error occurred while exporting the curriculum. Please check the console for details.');
        }
    });

    function generatePdf(curriculum, fileName) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: 'a4'
        });

        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        const margin = 15;

        // --- Reusable Header and Footer ---
        const addHeader = (doc) => {
            // You can add a logo here if you have one
            // doc.addImage(logo, 'PNG', margin, 5, 40, 15);
            doc.setFontSize(10);
            doc.setTextColor(150);
            doc.setFont('helvetica', 'italic');
            doc.text('Curriculum & Subject Management System', pageWidth - margin, 10, { align: 'right' });
            doc.setLineWidth(0.2);
            doc.line(margin, 15, pageWidth - margin, 15);
        };
        
        const addFooter = (doc) => {
            const pageCount = doc.internal.getNumberOfPages();
            doc.setFontSize(8);
            doc.setTextColor(150);
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.text(`Page ${i} of ${pageCount}`, pageWidth / 2, pageHeight - 10, { align: 'center' });
            }
        };

        // --- Title Page ---
        addHeader(doc);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(26);
        doc.setTextColor(40);
        doc.text(curriculum.curriculum, pageWidth / 2, pageHeight / 2 - 20, { align: 'center' });

        doc.setFont('helvetica', 'normal');
        doc.setFontSize(16);
        doc.setTextColor(100);
        doc.text(`Program Code: ${curriculum.program_code}`, pageWidth / 2, pageHeight / 2 - 10, { align: 'center' });
        doc.text(`Academic Year: ${curriculum.academic_year}`, pageWidth / 2, pageHeight / 2, { align: 'center' });
        
        // --- Curriculum Summary Page ---
        doc.addPage();
        addHeader(doc);
        let y = 30; // Initial Y position for content

        doc.setFont('helvetica', 'bold');
        doc.setFontSize(18);
        doc.text('Curriculum Checklist', pageWidth / 2, y, { align: 'center' });
        y += 15;

        const subjectsByYearAndSem = {};
        curriculum.subjects.forEach(subject => {
            const key = `${subject.pivot.year}-${subject.pivot.semester}`;
            if (!subjectsByYearAndSem[key]) subjectsByYearAndSem[key] = [];
            subjectsByYearAndSem[key].push(subject);
        });
        const sortedKeys = Object.keys(subjectsByYearAndSem).sort();

        for (const key of sortedKeys) {
            const [year, semester] = key.split('-');
            const semesterText = semester == 1 ? 'First Semester' : (semester == 2 ? 'Second Semester' : 'Summer');
            
            doc.setFontSize(14);
            doc.setFont('helvetica', 'bold');
            doc.text(`${getYearOrdinal(year)} Year - ${semesterText}`, margin, y);
            y += 7;

            const tableData = subjectsByYearAndSem[key].map(subject => {
                const prerequisites = subject.prerequisites.map(p => p.prerequisite_subject_code).join(', ') || 'None';
                return [subject.subject_code, subject.subject_name, subject.subject_unit, prerequisites];
            });

            doc.autoTable({
                startY: y,
                head: [['Code', 'Subject Name', 'Units', 'Prerequisites']],
                body: tableData,
                theme: 'grid',
                headStyles: { fillColor: [30, 58, 138] }, // Dark Blue
                styles: { font: 'helvetica', fontSize: 10 },
                margin: { left: margin, right: margin }
            });
            y = doc.lastAutoTable.finalY + 12;

            if (y > pageHeight - 30) {
                doc.addPage();
                addHeader(doc);
                y = 30;
            }
        }

        // --- Individual Subject Syllabus Pages ---
        curriculum.subjects.forEach(subject => {
            doc.addPage();
            addHeader(doc);
            y = 30;

            doc.setFontSize(18);
            doc.setFont("helvetica", "bold");
            doc.text("Subject Syllabus", pageWidth / 2, y, { align: 'center' });
            y += 15;

            const detailsData = [
                ['Subject Name:', subject.subject_name],
                ['Subject Code:', subject.subject_code],
                ['Subject Type:', subject.subject_type],
                ['Units:', subject.subject_unit.toString()]
            ];
            
            doc.autoTable({
                startY: y,
                body: detailsData,
                theme: 'grid',
                styles: { font: 'helvetica', fontSize: 11 },
                columnStyles: { 0: { fontStyle: 'bold', fillColor: '#f0f0f0' } },
                margin: { left: margin, right: margin }
            });
            y = doc.lastAutoTable.finalY + 15;

            doc.setFontSize(14);
            doc.setFont("helvetica", "bold");
            doc.text("Weekly Topics", margin, y);
            y += 8;

            const lessonsData = [];
            if (subject.lessons && typeof subject.lessons === 'object') {
                for (let i = 1; i <= 15; i++) {
                    const week = `Week ${i}`;
                    // Split long text into multiple lines
                    const lessonText = doc.splitTextToSize(subject.lessons[week] || 'N/A', pageWidth - margin * 2 - 30);
                    lessonsData.push([week, lessonText]);
                }
            }
            
            doc.autoTable({
                startY: y,
                head: [['Week', 'Lesson / Topics']],
                body: lessonsData,
                theme: 'grid',
                headStyles: { fillColor: [44, 62, 80] }, // Dark Grey
                styles: { font: 'helvetica', fontSize: 9, cellPadding: 2, valign: 'middle' },
                columnStyles: {
                    0: { cellWidth: 20, fontStyle: 'bold' },
                    1: { cellWidth: 'auto' }
                },
                margin: { left: margin, right: margin }
            });
        });

        addFooter(doc);
        doc.save(fileName);
    }
    
    // Keep the other helper functions (saveExportHistory, addHistoryItemToDOM, getYearOrdinal) as they are.
    async function saveExportHistory(curriculumId, fileName, format) {
        const response = await fetch('{{ route('curriculum_export_tool.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ curriculum_id: curriculumId, file_name: fileName, format: format })
        });
        if (!response.ok) throw new Error('Failed to save export history.');
        return await response.json();
    }

    function addHistoryItemToDOM(historyItem) {
        if (noHistoryMessage) noHistoryMessage.remove();
        const item = document.createElement('div');
        item.className = 'flex items-center justify-between p-4 border rounded-lg hover:shadow-md transition-shadow';
        const formattedDate = new Date(historyItem.created_at).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit'});
        item.innerHTML = `
            <div>
                <h3 class="font-semibold text-gray-800">${historyItem.curriculum.curriculum}</h3>
                <p class="text-sm text-gray-500">${historyItem.format} • ${formattedDate}</p>
            </div>
            <span class="text-gray-400">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </span>
        `;
        exportHistoryContainer.prepend(item);
    }

    function getYearOrdinal(year) {
        if (year === '1') return '1st';
        if (year === '2') return '2nd';
        if (year === '3') return '3rd';
        return `${year}th`;
    }
});
</script>
@endsection