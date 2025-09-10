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

                        {{-- CHED Links Section --}}
                        <div id="ched-links" class="hidden grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2">
                            @for ($year = 2025; $year >= 1994; $year--)
                                <a href="https://ched.gov.ph/{{ $year }}-ched-memorandum-orders/" target="_blank" class="group block p-3 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                    <span class="font-medium text-blue-700 group-hover:text-blue-800">
                                        {{ $year }} CHED Memorandum Orders
                                    </span>
                                </a>
                            @endfor
                        </div>

                        {{-- DepEd Links Section --}}
                        <div id="deped-links" class="hidden space-y-3">
                            {{-- Accordion for Shape Paper --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Shape Paper</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white">
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/The-Strengthened-Senior-High-School-Program-Shaping-Paper.pdf" target="_blank" class="block text-blue-600 hover:underline">The Strengthened Senior High School Program Shaping Paper</a>
                                </div>
                            </div>

                            {{-- Accordion for Curriculum Guides (Core) --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Curriculum Guides (Core)</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-2">
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Effective-Communication.pdf" target="_blank" class="block text-blue-600 hover:underline">Effective Communication</a>
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/General-Mathematics.pdf" target="_blank" class="block text-blue-600 hover:underline">General Mathematics</a>
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/General-Science.pdf" target="_blank" class="block text-blue-600 hover:underline">General Science</a>
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Life-and-Career-Skills.pdf" target="_blank" class="block text-blue-600 hover:underline">Life and Career Skills</a>
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Mabisang-Komunikasyon.pdf" target="_blank" class="block text-blue-600 hover:underline">Mabisang Komunikasyon</a>
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Pag-aaral-ng-Kasaysayan-at-Lipunang-Pilipino.pdf" target="_blank" class="block text-blue-600 hover:underline">Pag-aaral ng Kasaysayan at Lipunang Pilipino</a>
                                </div>
                            </div>

                            {{-- Accordion for Curriculum Guides (Academic) --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Curriculum Guides (Academic)</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-4">
                                    <div class="space-y-2">
                                        <h4 class="font-bold text-gray-600">ARTS, SOCIAL SCIENCE, AND HUMANITIES</h4>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Arts-1-Creative-Industries-Visual-Art-Literary-Art-Media-Art-Applied-Art-and-Traditional-Art.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Arts 1 (Creative Industries - Visual Art, Literary Art, Media Art, Applied Art, and Traditional Art)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Arts-2-Creative-Industries-II-%E2%80%93-Performing-Arts.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Arts 2 (Creative Industries II – Performing Arts)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Social-Science-1-Introduction-to-Social-Sciences.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Social Science 1 (Introduction to Social Sciences)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Humanities-1-Creative-Writing.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Humanities 1 (Creative Writing)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Humanities-2-Introduction-to-World-Religions-and-Belief-Systems.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Humanities 2 (Introduction to World Religions and Belief Systems)</a>
                                    </div>
                                    <div class="space-y-2">
                                        <h4 class="font-bold text-gray-600">ENGINEERING AND TECHNOLOGY</h4>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Engineering-1-Calculus.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Engineering 1 (Calculus)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Engineering-2-Fundamentals-of-Programming.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Engineering 2 (Fundamentals of Programming)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Engineering-3-Basic-Electricity-and-Electronics.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Engineering 3 (Basic Electricity and Electronics)</a>
                                    </div>
                                     <div class="space-y-2">
                                        <h4 class="font-bold text-gray-600">BUSINESS, ECONOMICS, AND MANAGEMENT</h4>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Business-1-Business-Enterprise-Simulation.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Business 1 (Business Enterprise Simulation)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Economics-1-Introduction-to-Economics.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Economics 1 (Introduction to Economics)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Management-1-Fundamentals-of-Accountancy-Business-and-Management.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Management 1 (Fundamentals of Accountancy, Business, and Management)</a>
                                    </div>
                                     <div class="space-y-2">
                                        <h4 class="font-bold text-gray-600">HEALTH AND MEDICAL SCIENCES</h4>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Health-Science-1-Introduction-to-Health-Science.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Health Science 1 (Introduction to Health Science)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Health-Science-2-Basic-Human-Anatomy-and-Physiology.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Health Science 2 (Basic Human Anatomy and Physiology)</a>
                                    </div>
                                </div>
                            </div>

                             {{-- Accordion for Curriculum Guides (TechPro) --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Curriculum Guides (TechPro)</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-4">
                                     <div class="space-y-2">
                                        <h4 class="font-bold text-gray-600">INFORMATION AND COMMUNICATIONS TECHNOLOGY</h4>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Digital-Tools-and-Productivity-Applications.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Digital Tools and Productivity Applications</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Multimedia-Development-and-Design.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Multimedia Development and Design</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Computer-Systems-and-Network-Administration.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Computer Systems and Network Administration</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Web-Development.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Web Development</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Computer-Programming.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Computer Programming</a>
                                    </div>
                                </div>
                            </div>
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

    // Accordion Logic for DepEd links
    document.querySelectorAll('.accordion-header').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');

            const isHidden = content.classList.contains('hidden');
            content.classList.toggle('hidden', !isHidden);
            icon.classList.toggle('rotate-180', isHidden);
        });
    });
});
</script>
@endsection
