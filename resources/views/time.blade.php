@extends('layouts.app')

@section('content')
<main class="p-6 flex-1">
    <div id="alert-container" class="mb-4">
        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <form id="time-form" action="{{ route('time.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="work-date" class="block text-gray-700 font-bold mb-2">Choose Date <span class="text-red-500">*</span></label>
                <input type="date" name="work_date"  id="work-date" value="{{ old('work_date') }}" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('work_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="project" class="block text-gray-700 font-bold mb-2">Project <span class="text-red-500">*</span></label>
                <select id="project" name="project" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Select a Project --</option>
                    <option value="website-redesign" {{ old('project') == 'website-redesign' ? 'selected' : '' }}>Website Redesign</option>
                    <option value="mobile-app" {{ old('project') == 'mobile-app' ? 'selected' : '' }}>Mobile App Development</option>
                    <option value="backend-api" {{ old('project') == 'backend-api' ? 'selected' : '' }}>Backend API Integration</option>
                    <option value="marketing-campaign" {{ old('project') == 'marketing-campaign' ? 'selected' : '' }}>Marketing Campaign</option>
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label for="task-description" class="block text-gray-700 font-bold mb-2">Task Description <span class="text-red-500">*</span></label>
            <textarea id="task-description" name="task_description" rows="3" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Describe the tasks you worked on">{{ old('task_description') }}</textarea>
            @error('task_description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="hours-minutes" class="block text-gray-700 font-bold mb-2">Time Spent (HH:MM) <span class="text-red-500">*</span></label>
            <input type="text" name="time_spent" id="hours-minutes" value="{{ old('time_spent') }}" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 08:30" required>
            @error('time_spent')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" id="add-task-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                Add Task
            </button>
        </div>
    </form>

    <div class="mt-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Daily Tasks</h3>
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Project</th>
                    <th class="py-3 px-6 text-left">Task Description</th>
                    <th class="py-3 px-6 text-left">Time Spent</th>
                </tr>
            </thead>
            <tbody id="task-list" class="text-gray-600 text-sm font-light">
                @forelse($timeLogs as $log)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">{{ $projectNames[$log->project] ?? $log->project }}</td>
                        <td class="py-3 px-6 text-left">{{ $log->task_description }}</td>
                        <td class="py-3 px-6 text-left">
                             {{ intdiv($log->time_spent, 60) }}h {{ $log->time_spent % 60 }}m
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-3 px-6 text-center text-gray-500">
                            No tasks logged yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- <div class="mt-4 text-right">
            <p class="font-bold">Total Time for Selected Date: <span id="total-time" class="text-blue-600">00:00</span></p>
        </div> --}}
    </div>

    </div>
</main>


@endsection
