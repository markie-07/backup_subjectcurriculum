{{-- resources/views/partials/grade_component_table.blade.php --}}

<div class="period-container border border-gray-200 rounded-lg" data-period="{{ $period }}">
    {{-- Accordion Header --}}
    <button type="button" class="accordion-toggle w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-t-lg">
        <div class="flex items-center">
            <span class="font-semibold text-lg capitalize">{{ $period }}</span>
            <input type="number" value="{{ $weight }}" class="semestral-input ml-4 w-20 text-center font-bold border-gray-300 rounded-md shadow-sm" data-part="{{ $period }}">
            <span class="ml-1 text-lg">%</span>
        </div>
        <div class="flex items-center">
            <span class="text-sm mr-2">Sub-total: <span class="sub-total font-bold text-gray-700">100%</span></span>
            <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
    </button>
    
    {{-- Accordion Content --}}
    <div class="accordion-content p-4 bg-white rounded-b-lg">
        <table class="w-full text-sm">
            <thead class="border-b">
                <tr>
                    <th class="p-2 text-left font-semibold text-gray-600">Component</th>
                    <th class="p-2 text-center font-semibold text-gray-600 w-24">Weight (%)</th>
                    <th class="p-2 text-center font-semibold text-gray-600 w-28">Actions</th>
                </tr>
            </thead>
            <tbody class="component-tbody">
                {{-- Dynamic rows will be inserted here by JavaScript --}}
            </tbody>
        </table>
        <div class="mt-4 text-right">
            <button type="button" class="add-component-btn text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">+ Add Main Component</button>
        </div>
    </div>
</div>