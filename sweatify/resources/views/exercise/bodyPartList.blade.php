<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Exercises based on body parts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <ul id="body-part-list" class="mt-4 space-y-2">
                    <!-- Body parts will be populated here -->
                </ul>
            </div>
        </div>
    </div>

    <script>
        async function fetchBodyParts() {
            const response = await fetch('/api/exercises/bodyPartList', {
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) {
                console.error('Error fetching body parts:', response.status);
                return;
            }

            const bodyParts = await response.json();
            const bodyPartList = document.getElementById('body-part-list');
            bodyPartList.innerHTML = '';

            bodyParts.forEach(bodyPart => {
                const li = document.createElement('li');
                li.textContent = bodyPart;
                li.classList.add('p-2', 'bg-gray-100', 'dark:bg-gray-700', 'rounded-md', 'cursor-pointer', 'hover:bg-gray-200', 'dark:hover:bg-gray-600', 'dark:text-gray-200');

                // Clickable link to exercise details
                li.setAttribute('data-name', bodyPart);
                li.onclick = () => {
                    const bodyPartName = li.getAttribute('data-name');
                    window.location.href = `/exercises/body-part/${bodyPartName}`;
                };

                bodyPartList.appendChild(li);
            });
        }

        document.addEventListener('DOMContentLoaded', fetchBodyParts);
    </script>
</x-app-layout>
