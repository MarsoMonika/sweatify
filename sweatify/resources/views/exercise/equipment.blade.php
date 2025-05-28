<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Exercises for ') }}<span id="equipment-name" class="font-semibold"></span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <label for="limit" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Number of Exercises per Page:</label>
                <select id="limit" class="mt-1 block w-full" onchange="fetchExercises(true)">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>

                <ul id="exercise-list" class="mt-4 space-y-2">
                    <!-- Exercise names will be populated here -->
                </ul>

                <!-- Pagination Controls -->
                <div class="mt-4 flex justify-between items-center">
                    <button id="prevPage" class="bg-gray-500 text-white px-4 py-2 rounded disabled:opacity-50" onclick="changePage(-1)">
                        Previous
                    </button>

                    <span id="page-info" class="text-gray-700 dark:text-gray-300">
                        Page <span id="current-page">1</span> of <span id="total-pages">1</span>
                    </span>

                    <button id="nextPage" class="bg-gray-500 text-white px-4 py-2 rounded disabled:opacity-50" onclick="changePage(1)">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let offset = 0; // Current offset
        let limit = 10; // Default limit
        let totalExercises = 0; // Total exercises count
        const equipment = decodeURIComponent(window.location.pathname.split('/').pop()); // Extract equipment name from the URL

        // Set equipment name in the header
        document.getElementById('equipment-name').textContent = equipment.charAt(0).toUpperCase() + equipment.slice(1);

        async function fetchExercises(resetOffset = false) {
            if (resetOffset) offset = 0; // Reset offset if limit changes

            limit = parseInt(document.getElementById('limit').value);
            const response = await fetch(`/api/exercises/equipment/${equipment}?limit=${limit}&offset=${offset}`, {
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) {
                console.error('Error fetching exercises:', response.status);
                return;
            }

            const data = await response.json();
            totalExercises = data.total; // Update total count

            const exerciseList = document.getElementById('exercise-list');
            exerciseList.innerHTML = '';

            data.exercises.forEach(exercise => {
                const li = document.createElement('li');
                li.textContent = exercise.name;
                li.classList.add('p-2', 'bg-gray-100', 'dark:bg-gray-700', 'rounded-md', 'cursor-pointer', 'hover:bg-gray-200', 'dark:hover:bg-gray-600', 'dark:text-gray-200');

                // Set data-id attribute for exercise and clickable link
                li.setAttribute('data-id', exercise.id);
                li.onclick = () => {
                    window.location.href = `/exercises/id/${exercise.id}`;
                };

                exerciseList.appendChild(li);
            });

            updatePagination();
        }

        function changePage(direction) {
            offset += direction * limit; // Move forward or backward by "limit" count
            fetchExercises();
        }

        function updatePagination() {
            const currentPage = Math.floor(offset / limit) + 1;
            const totalPages = Math.ceil(totalExercises / limit);

            document.getElementById('current-page').textContent = currentPage;
            document.getElementById('total-pages').textContent = totalPages;

            document.getElementById('prevPage').disabled = offset <= 0;
            document.getElementById('nextPage').disabled = offset + limit >= totalExercises;
        }

        document.addEventListener('DOMContentLoaded', fetchExercises);
    </script>
</x-app-layout>
