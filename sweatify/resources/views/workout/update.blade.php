<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Workout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form id="workout-form">
                    @csrf
                    @method('PUT')

                    <!-- Workout Name -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Workout Name</label>
                        <input type="text" required="required" name="name" id="workout-name" class="w-full p-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="workout-description" required="required" class="w-full p-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"></textarea>
                    </div>

                    <!-- Select Workout Type -->
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Workout Type</label>
                            <select name="type" id="workout-type" required="required" class="w-full p-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>
                        <span class="workout-emoji text-5xl">💪</span>
                    </div>

                    <!-- Select Exercises -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Select Exercises</label>
                        <div id="exercise-container" class="space-y-2">
                            <!-- Exercise options will be populated dynamically -->
                        </div>
                        <button type="button" id="add-exercise" class="mt-2 bg-green-500 text-white px-2 py-1 rounded text-3xl text-5xl">+</button>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="text-white px-4 py-2 rounded" style="background-color: greenyellow; color: black">
                            Update Workout 🏋️‍♂️
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let exercises = [];
        let workoutTypes = [];
        let workoutData = {};  // To store the current workout data

        // Get the workout ID from the URL
        const urlSegments = window.location.pathname.split('/');
        const workoutId = urlSegments[urlSegments.length - 1]; // Get the last segment which is the workout ID

        async function fetchWorkoutData(id) {
            const response = await fetch(`/api/workouts/id/${id}`, {
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) {
                console.error('Error fetching workout data:', response.status);
                return;
            }

            workoutData = await response.json();
            populateForm(workoutData);
        }

        async function fetchWorkoutTypes() {
            const response = await fetch('/api/workouts/types', {
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) {
                console.error('Error fetching workout types:', response.status);
                return;
            }

            const data = await response.json();
            workoutTypes = data.types;
            populateWorkoutTypes();
        }

        async function fetchExercises() {
            const response = await fetch(`/api/exercises?limit=1000&offset=0`, {
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) {
                console.error('Error fetching exercises:', response.status);
                return;
            }

            const data = await response.json();
            exercises = data.exercises;

            // After exercises are fetched, populate the options for the initial exercises
            populateExerciseOptions(workoutData.exercises);
        }

        function populateWorkoutTypes() {
            const workoutTypeSelect = document.getElementById('workout-type');
            workoutTypeSelect.innerHTML = '';

            const placeholderOption = document.createElement('option');
            placeholderOption.value = '';
            placeholderOption.disabled = true;
            placeholderOption.selected = true;
            placeholderOption.textContent = 'Select a workout type';
            workoutTypeSelect.appendChild(placeholderOption);

            workoutTypes.forEach(type => {
                const option = document.createElement('option');
                option.value = type;
                option.textContent = type.charAt(0).toUpperCase() + type.slice(1); // Capitalize first letter
                workoutTypeSelect.appendChild(option);
            });
        }

        function populateExerciseOptions(workoutExercises = []) {
            const container = document.getElementById('exercise-container');

            // Populate each exercise select field based on workout data
            workoutExercises.forEach(exercise => {
                const exerciseSelect = document.createElement('div');
                exerciseSelect.classList.add('exercise-select', 'flex', 'items-center', 'space-x-2', 'mt-2');
                exerciseSelect.innerHTML = `
                <select name="exercise_ids[]" class="w-full p-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    ${exercises.map(ex => `
                        <option value="${ex.id}" ${exercise.id === ex.id ? 'selected' : ''}>
                            ${ex.name}
                        </option>
                    `).join('')}
                </select>
                <button type="button" class="remove-exercise bg-red-500 text-white px-2 py-1 rounded text-5xl">-</button>
            `;
                container.appendChild(exerciseSelect);
            });
        }

        function populateForm(workoutData) {
            // Populate the form with the fetched workout data
            document.getElementById('workout-name').value = workoutData.name;
            document.getElementById('workout-description').value = workoutData.description;
            document.getElementById('workout-type').value = workoutData.type;

            // Populate the emoji based on the workout type
            updateEmoji(workoutData.type);

            // Populate the exercises
            populateExerciseOptions(workoutData.exercises);
        }

        function updateEmoji(type) {
            let emoji;
            switch (type) {
                case 'cardio':
                    emoji = '❤️‍🔥';
                    break;
                case 'strength':
                    emoji = '🏋️‍️';
                    break;
                case 'endurance':
                    emoji = '🏃';
                    break;
                case 'flexibility':
                    emoji = '🤸';
                    break;
                case 'swimming':
                    emoji = '🏊';
                    break;
                case 'dance':
                    emoji = '💃';
                    break;
                default:
                    emoji = '💪';
            }

            document.querySelectorAll('.workout-emoji').forEach(span => {
                span.textContent = emoji;
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchExercises();
            fetchWorkoutTypes();
            fetchWorkoutData(workoutId);

            // Handle adding new exercise fields
            document.querySelector('#add-exercise').addEventListener('click', function() {
                const container = document.createElement('div');
                container.classList.add('exercise-select', 'flex', 'items-center', 'space-x-2', 'mt-2');
                container.innerHTML = `
                <select name="exercise_ids[]" class="w-full p-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"></select>
                <button type="button" class="remove-exercise bg-red-500 text-white px-2 py-1 rounded text-5xl">-</button>
            `;
                document.querySelector('#exercise-container').appendChild(container);

                // Populate the new select element with exercise options
                const newSelect = container.querySelector('select');
                exercises.forEach(ex => {
                    const option = document.createElement('option');
                    option.value = ex.id;
                    option.textContent = ex.name;
                    newSelect.appendChild(option);
                });
            });

            document.querySelector('#exercise-container').addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-exercise')) {
                    event.target.parentElement.remove();
                }
            });
        });

        document.getElementById('workout-type').addEventListener('change', function() {
            const workoutType = this.value;
            updateEmoji(workoutType);
        });


        document.getElementById('workout-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            for (const [key, value] of formData.entries()) {
                console.log(key, value);  // Log the key-value pairs
            }

            fetch(`/api/workouts/update/${workoutId}`, {
                method: 'PUT',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data && data.id) {
                        window.location.href = `/workouts/id/${workoutId}`;
                    } else {
                        alert('Failed to update workout. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the workout.');
                });
        });
    </script>
</x-app-layout>
