<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create a New Workout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form id="workout-form">
                    @csrf

                    <!-- Workout Name -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Workout Name</label>
                        <input type="text" required="required" name="name" class="w-full p-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" required="required" class="w-full p-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"></textarea>
                    </div>

                    <!-- Select Workout Type -->
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Workout Type</label>
                        <select name="type" required="required" id="workout-type" class="w-full p-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <!-- Options will be populated dynamically -->
                        </select>
                        </div>
                        <span class="workout-emoji text-5xl">💪</span>
                    </div>

                    <!-- Select Exercises -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Select Exercises</label>
                        <div id="exercise-container" class="space-y-2">
                            <div class="exercise-select flex items-center space-x-2">
                                <select name="exercise_ids[]" required="required" class="w-full p-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                        <button type="button" id="add-exercise" class="mt-2 bg-green-500 text-white px-2 py-1 rounded text-3xl text-5xl">+</button>
                    </div>


                    <div class="flex justify-end">
                        <!-- Submit Button -->
                        <button type="submit" class="text-white px-4 py-2 rounded" style="background-color: greenyellow; color: black">
                            Create Workout <span class="workout-emoji">💪</span>
                        </button>
                    </div>


                </form>
            </div>
        </div>
    </div>

    <script>
        let exercises = [];
        let workoutTypes = [];


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
                option.textContent = type.charAt(0).toUpperCase() + type.slice(1);  // Capitalize the first letter
                workoutTypeSelect.appendChild(option);
            });
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
            populateExerciseOptions();
        }


        function populateExerciseOptions() {
            document.querySelectorAll("select[name='exercise_ids[]']").forEach(select => {
                const selectedValue = select.value;
                select.innerHTML = '';

                const placeholderOption = document.createElement('option');
                placeholderOption.value = '';
                placeholderOption.disabled = true;
                placeholderOption.selected = true;
                placeholderOption.textContent = 'Select an exercise';
                select.appendChild(placeholderOption);

                exercises.forEach(exercise => {
                    const option = document.createElement('option');
                    option.value = exercise.id;
                    option.textContent = exercise.name;
                    select.appendChild(option);
                });

                select.value = selectedValue;
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchExercises();
            fetchWorkoutTypes();

            document.querySelector('#add-exercise').addEventListener('click', function() {
                const container = document.createElement('div');
                container.classList.add('exercise-select', 'flex', 'items-center', 'space-x-2', 'mt-2');
                container.innerHTML = `
                    <select name="exercise_ids[]" class="w-full p-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"></select>
                    <button type="button" class="remove-exercise bg-red-500 text-white px-2 py-1 rounded text-5xl">-</button>
                `;
                document.querySelector('#exercise-container').appendChild(container);
                populateExerciseOptions();
            });

            document.querySelector('#exercise-container').addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-exercise')) {
                    event.target.parentElement.remove();
                }
            });
        });

        document.getElementById('workout-type').addEventListener('change', function() {
            const workoutType = this.value;
            let emoji;

            switch (workoutType) {
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

        });


        document.getElementById('workout-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/api/workouts/create', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data && data.id) {
                        window.location.href = '/home';
                    } else {
                        alert('Failed to create workout. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while creating the workout.');
                });
        });
    </script>
</x-app-layout>
