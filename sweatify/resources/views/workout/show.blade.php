<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Workout Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 relative">


                <span class="absolute top-0 right-0 mr-2 mt-2 text-5xl">
                    @php
                        $emojiMap = [
                            'cardio' => '❤️‍🔥',
                            'strength' => '🏋️‍️',
                            'endurance' => '🏃',
                            'flexibility' => '🤸',
                            'swimming' => '🏊',
                            'dance' => '💃',
                        ];
                        $emoji = $emojiMap[$workout->type] ?? '💪';
                    @endphp
                    {{ $emoji }}
                </span>


                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $workout->name }}</h1>
                <p class="text-gray-700 dark:text-gray-300 mb-2 pr-16">{{ $workout->description ?? 'No description available' }}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-2 pr-16">Created at: {{ $workout->created_at->format('Y-m-d H:i') }}</p>

                @if ($workout->updated_at != $workout->created_at)
                    <p class="text-gray-700 dark:text-gray-300 mb-2 pr-16">Updated at: {{ $workout->updated_at->format('Y-m-d H:i') }}</p>
                @endif

                <p class="text-gray-700 dark:text-gray-300 mb-2 pr-16">ID: {{ $workout->id }}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-2 pr-16">Type: {{ $workout->type }}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-4 pr-16">Is custom: {{ $workout->is_custom ? 'true' : 'false' }}</p>

                <!-- Exercises List -->
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Exercises</h3>
                <ul class="space-y-2">
                    @foreach ($exercises as $exercise)
                        <li class="p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                            <a href="{{ route('exercise.show', ['id' => $exercise->id]) }}"
                               class="text-blue-500 hover:text-blue-600">
                                {{ $exercise->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6 flex justify-between items-center">

                    <div x-data="{ showForm: false }">
                        <button
                            x-show="!showForm"
                            @click="showForm = true"
                            class="bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600">
                            Start this workout! 🚀
                        </button>
                        <form x-show="showForm" method="POST" action="{{ route('history.store') }}" class="mt-6 space-y-4">
                            @csrf
                            <input type="hidden" name="workout_id" value="{{ $workout->id }}">
                            @foreach ($exercises as $exercise)
                                <div class="flex items-center gap-4 bg-gray-100 dark:bg-gray-700 rounded-md p-2">
                                    <span class="w-40">{{ $exercise->name }}</span>
                                    <input type="hidden" name="exercise_data[{{ $loop->index }}][exercise_id]" value="{{ $exercise->id }}">
                                    <label>
                                        Reps:
                                        <input
                                            type="number"
                                            name="exercise_data[{{ $loop->index }}][reps]"
                                            class="border rounded px-2 py-1 w-20"
                                            min="1" required>
                                    </label>
                                    <label>
                                        Weight (kg):
                                        <input
                                            type="number"
                                            name="exercise_data[{{ $loop->index }}][weight]"
                                            class="border rounded px-2 py-1 w-24"
                                            min="0" step="0.1" required>
                                    </label>
                                </div>
                            @endforeach
                            <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                Save Workout
                            </button>
                        </form>
                    </div>

                    <!-- Only for custom workouts -->
                    @if ($workout->is_custom)
                        <div class="flex gap-4">
                            <form method="POST" action="{{ route('workouts.destroy', $workout->id) }}"
                                  onsubmit="return confirm('Are you sure you want to delete this workout?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600">
                                    Delete workout 🗑️
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
