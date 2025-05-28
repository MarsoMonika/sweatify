<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Exercises based on equipment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <ul id="equipment-list" class="mt-4 space-y-2">
                    <!-- Equipments will be populated here -->
                </ul>
            </div>
        </div>
    </div>

    <script>
        async function fetchEquipments() {
            const response = await fetch('/api/exercises/equipmentList', {
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) {
                console.error('Error fetching equipments:', response.status);
                return;
            }

            const equipments = await response.json();
            const equipmentList = document.getElementById('equipment-list');
            equipmentList.innerHTML = '';

            equipments.forEach(Equipment => {
                const li = document.createElement('li');
                li.textContent = Equipment;
                li.classList.add('p-2', 'bg-gray-100', 'dark:bg-gray-700', 'rounded-md', 'cursor-pointer', 'hover:bg-gray-200', 'dark:hover:bg-gray-600', 'dark:text-gray-200');

                // Clickable link to exercise details
                li.setAttribute('data-name', Equipment);
                li.onclick = () => {
                    const equipmentName = li.getAttribute('data-name');
                    window.location.href = `/exercises/equipment/${equipmentName}`;
                };

                equipmentList.appendChild(li);
            });
        }

        document.addEventListener('DOMContentLoaded', fetchEquipments);
    </script>
</x-app-layout>
