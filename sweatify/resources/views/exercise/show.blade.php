<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Exercise Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 id="exercise-name" class="text-2xl font-bold text-gray-800 dark:text-gray-200"></h1>
                <img id="exercise-gif" class="mt-4 w-full max-w-md rounded-lg shadow-md" alt="Exercise GIF">

                <div class="mt-4 dark:text-gray-200">
                    <p><strong>Target Muscle:</strong> <span id="exercise-target"></span></p>
                    <p><strong>Body Part:</strong> <span id="exercise-bodypart"></span></p>
                    <p><strong>Equipment:</strong> <span id="exercise-equipment"></span></p>
                </div>

                <div class="mt-4">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Instructions:</h3>
                    <ol id="exercise-instructions" class="pl-5 space-y-2 dark:text-gray-300" style="list-style-type: decimal; padding-left: 1.5rem;"></ol>
                </div>

                <div class="mt-4">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Secondary Muscles:</h3>
                    <ul id="exercise-secondary" class="list-disc pl-5"></ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async function () {
            const urlParts = window.location.pathname.split('/');
            const exerciseId = urlParts[urlParts.length - 1];

            const response = await fetch(`/api/exercises/id/${exerciseId}`, {
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) {
                console.error('Error fetching exercise:', response.status);
                return;
            }

            const exercise = await response.json();

            document.getElementById('exercise-name').textContent = exercise.name;
            document.getElementById('exercise-gif').src = exercise.gifUrl;
            document.getElementById('exercise-gif').alt = `${exercise.name} image`;
            document.getElementById('exercise-target').textContent = exercise.target;
            document.getElementById('exercise-bodypart').textContent = exercise.bodyPart;
            document.getElementById('exercise-equipment').textContent = exercise.equipment || 'None';

            // Instructions list
            const instructionsList = document.getElementById('exercise-instructions');
            instructionsList.innerHTML = '';
            exercise.instructions.forEach(instruction => {
                const li = document.createElement('li');
                li.textContent = instruction;
                li.classList.add('dark:text-gray-300');
                instructionsList.appendChild(li);
            });

            // Secondary muscles list
            const secondaryList = document.getElementById('exercise-secondary');
            secondaryList.innerHTML = '';
            if (exercise.secondaryMuscles && exercise.secondaryMuscles.length > 0) {
                exercise.secondaryMuscles.forEach(muscle => {
                    const li = document.createElement('li');
                    li.textContent = muscle;
                    li.classList.add('dark:text-gray-400');
                    secondaryList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.textContent = 'None';
                secondaryList.appendChild(li);
            }
        });
    </script>
</x-app-layout>
