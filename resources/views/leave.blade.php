@extends('layouts.app')

@section('content')
<main class="p-6 flex-1">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Leave Application</h2>

        <div id="alert-container" class="mb-4">
            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->has('leave'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ $errors->first('leave') }}
                </div>
            @endif
        </div>

        <form id="leave-form"  method="POST" action="{{ route('leaves.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="start-date" class="block text-gray-700 font-bold mb-2">Start Date <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" id="start-date" value="{{ old('start_date') }}" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" >
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    </div>

                <div>
                    <label for="end-date" class="block text-gray-700 font-bold mb-2">End Date <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" id="end-date" value="{{ old('end_date') }}" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" >
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="leave-reason" class="block text-gray-700 font-bold mb-2">Reason for Leave <span class="text-red-500">*</span></label>
                <textarea id="leave-reason" name="reason" rows="4" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"  placeholder="Describe the reason for your leave">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Apply for Leave
                </button>
            </div>
        </form>

        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Leave History</h3>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Start Date</th>
                        <th class="py-3 px-6 text-left">End Date</th>
                        <th class="py-3 px-6 text-left">Reason</th>
                        <th class="py-3 px-6 text-left">Status</th>
                    </tr>
                </thead>
                <tbody id="leave-history" class="text-gray-600 text-sm font-light">
                    @forelse($leaves as $leave)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $leave->start_date }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $leave->end_date }}</td>
                            <td class="py-3 px-6 text-left">{{ $leave->reason }}</td>
                            <td class="py-3 px-6 text-left">
                                <span class="bg-blue-200 text-blue-800 py-1 px-2 rounded-full text-xs">Pending</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">No leaves applied yet.</td>
                        </tr>
                    @endforelse
                </tbody>

                {{-- <tbody id="leave-history" class="text-gray-600 text-sm font-light">
                </tbody> --}}
            </table>
        </div>
    </div>
</main>

<script>
    // document.addEventListener('DOMContentLoaded', () => {
    //     const startDateInput = document.getElementById('start-date');
    //     const endDateInput = document.getElementById('end-date');
    //     const leaveForm = document.getElementById('leave-form');
    //     const alertContainer = document.getElementById('alert-container');
    //     const leaveHistoryTable = document.getElementById('leave-history');

    //     // --- Data Simulation ---
    //     // This array simulates dates for which a work report has already been submitted.
    //     const workReportDates = ['2025-08-20', '2025-08-22', '2025-08-25'];

    //     // --- Form Submission Logic ---
    //     leaveForm.addEventListener('submit', (event) => {
    //         event.preventDefault();

    //         const startDate = startDateInput.value;
    //         const endDate = endDateInput.value;
    //         const leaveReason = document.getElementById('leave-reason').value;

    //         // Clear previous alerts
    //         showAlert(null);

    //         // Validation 1: Start date must not be after end date
    //         if (new Date(startDate) > new Date(endDate)) {
    //             showAlert('End date cannot be before start date.', 'warning');
    //             return;
    //         }

    //         // Validation 2: Check for work report conflicts
    //         const conflictingDates = getDatesInRange(startDate, endDate).filter(date => workReportDates.includes(date));

    //         if (conflictingDates.length > 0) {
    //             showAlert(`You have already submitted a work report for the following dates: ${conflictingDates.join(', ')}. Please adjust your leave dates.`, 'danger');
    //             return;
    //         }

    //         // If all validation passes, proceed with form submission logic (simulated)
    //         const newRow = document.createElement('tr');
    //         newRow.className = 'border-b border-gray-200 hover:bg-gray-100';
    //         newRow.innerHTML = `
    //             <td class="py-3 px-6 text-left whitespace-nowrap">${startDate}</td>
    //             <td class="py-3 px-6 text-left whitespace-nowrap">${endDate}</td>
    //             <td class="py-3 px-6 text-left">${leaveReason}</td>
    //             <td class="py-3 px-6 text-left"><span class="bg-blue-200 text-blue-800 py-1 px-2 rounded-full text-xs">Pending</span></td>
    //         `;
    //         leaveHistoryTable.appendChild(newRow);

    //         showAlert('Leave application submitted successfully!', 'success');
    //         leaveForm.reset();
    //     });

    //     // --- Helper Functions ---

    //     // Generates a list of dates between a start and end date (inclusive)
    //     function getDatesInRange(startDate, endDate) {
    //         const dates = [];
    //         let currentDate = new Date(startDate);
    //         const stopDate = new Date(endDate);

    //         while (currentDate <= stopDate) {
    //             dates.push(currentDate.toISOString().split('T')[0]);
    //             currentDate.setDate(currentDate.getDate() + 1);
    //         }
    //         return dates;
    //     }

    //     // Simple alert message function (reused from previous response)
    //     function showAlert(message, type) {
    //         alertContainer.innerHTML = '';
    //         if (!message) return;

    //         let alertClasses = 'relative px-4 py-3 rounded-lg border-l-4 ';
    //         let textClasses = 'font-bold';
    //         let icon = '';

    //         switch (type) {
    //             case 'success':
    //                 alertClasses += 'bg-green-100 border-green-500 text-green-700';
    //                 icon = '✅';
    //                 break;
    //             case 'danger':
    //                 alertClasses += 'bg-red-100 border-red-500 text-red-700';
    //                 icon = '❌';
    //                 break;
    //             case 'warning':
    //                 alertClasses += 'bg-yellow-100 border-yellow-500 text-yellow-700';
    //                 icon = '⚠️';
    //                 break;
    //         }

    //         alertContainer.innerHTML = `
    //             <div class="${alertClasses}" role="alert">
    //                 <p class="${textClasses}">${icon} ${message}</p>
    //             </div>
    //         `;
    //     }
    // });
</script>
@endsection
