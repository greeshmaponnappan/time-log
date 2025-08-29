@extends('layouts.app')

@section('content')
<main class="p-6 flex-1">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 font-semibold mb-2">Total Work Hours (Today)</h3>
            <p class="text-4xl font-bold text-gray-800">
                {{ floor($totalMinutes / 60) }}h {{ $totalMinutes % 60 }}m
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 font-semibold mb-2">Leave Applications (Today)</h3>
            <p class="text-4xl font-bold text-gray-800">{{ $leaveCountToday }}</p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-1 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Project Time Tracker</h3>
            <div class="space-y-4">
                @foreach($timeLogs as $log)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-semibold">{{ $projectNames[$log->project] ?? $log->project }}</h4>
                            <p class="text-sm text-gray-500">Task: {{ $log->task_description }}</p>
                        </div>
                        <span class="text-lg font-bold">
                            {{ intdiv($log->time_spent, 60) }}h {{ $log->time_spent % 60 }}m
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</main>

@endsection
