@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    <div class="container mx-auto">
        {{-- Main Content Section --}}
        <div class="bg-white p-10 md:p-12 rounded-2xl shadow-lg border border-gray-200">
            
            {{-- Page Title Section --}}
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Compliance Validator</h1>
                <p class="text-lg text-gray-600 mt-1">Select an agency to view and access official memorandum orders.</p>
            </div>

            {{-- Main Interactive Area --}}
            <div class="border border-gray-200 rounded-2xl p-8">
                <div class="relative inline-block text-left w-full max-w-md">
                    <div>
                        <button type="button" id="agency-button" class="inline-flex justify-between w-full rounded-lg border border-gray-300 shadow-sm px-5 py-3 bg-white text-base font-medium text-gray-800 hover:bg-gray-50 hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" aria-haspopup="true" aria-expanded="true">
                            <span id="selected-agency" class="font-semibold">Select Agency</span>
                        </button>
                    </div>

                    <div id="agency-menu" class="origin-top-right absolute left-0 mt-2 w-full rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-10" role="menu" aria-orientation="vertical" aria-labelledby="agency-button">
                        <div class="py-1" role="none">
                            <button type="button" class="agency-option text-gray-700 block w-full text-left px-4 py-3 text-base hover:bg-blue-100 hover:text-blue-800" role="menuitem" data-agency="CHED" data-target="ched-links">CHED</button>
                            <button type="button" class="agency-option text-gray-700 block w-full text-left px-4 py-3 text-base hover:bg-blue-100 hover:text-blue-800" role="menuitem" data-agency="DepEd" data-target="deped-links">DepEd</button>
                        </div>
                    </div>
                </div>

                <div id="links-container" class="hidden mt-8">
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-8">
                        <h3 id="links-header" class="text-lg font-semibold text-gray-800 mb-6 border-b border-gray-200 pb-4"></h3>
                        
                        <div id="ched-links" class="hidden grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2">
                            @for ($year = 2025; $year >= 1994; $year--)
                                <a href="https://ched.gov.ph/{{ $year }}-ched-memorandum-orders/" target="_blank" class="group block p-3 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                    <span class="font-medium text-blue-700 group-hover:text-blue-800">
                                        {{ $year }} CHED Memorandum Orders
                                    </span>
                                </a>
                            @endfor
                        </div>

                        <div id="deped-links" class="hidden">
                            <p class="text-gray-600">DepEd Issuances will be displayed here once available.</p>
                            {{-- Add DepEd links here in the future --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const agencyButton = document.getElementById('agency-button');
    const agencyMenu = document.getElementById('agency-menu');
    const linksContainer = document.getElementById('links-container');
    const selectedAgencySpan = document.getElementById('selected-agency');
    const linksHeader = document.getElementById('links-header');

    // Toggle dropdown menu
    agencyButton.addEventListener('click', () => {
        const isHidden = agencyMenu.classList.contains('hidden');
        agencyMenu.classList.toggle('hidden', !isHidden);
        agencyButton.setAttribute('aria-expanded', isHidden);
    });

    // Handle agency selection
    document.querySelectorAll('.agency-option').forEach(button => {
        button.addEventListener('click', () => {
            const agency = button.dataset.agency;
            const targetId = button.dataset.target;

            // Update button text and links header
            selectedAgencySpan.textContent = agency;
            linksHeader.textContent = `Available ${agency} Issuances`;

            // Hide the agency selection dropdown
            agencyMenu.classList.add('hidden');
            agencyButton.setAttribute('aria-expanded', 'false');

            // Show the main links container
            linksContainer.classList.remove('hidden');

            // Hide all specific link sections
            linksContainer.querySelectorAll('div[id$="-links"]').forEach(div => {
                div.classList.add('hidden');
            });

            // Show the target link section
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.remove('hidden');
            }
        });
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', (e) => {
        if (!agencyButton.contains(e.target) && !agencyMenu.contains(e.target)) {
            agencyMenu.classList.add('hidden');
            agencyButton.setAttribute('aria-expanded', 'false');
        }
    });
});
</script>
@endsection