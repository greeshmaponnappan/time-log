<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Repositories\LeaveRepository;
use App\Interfaces\LeaveRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $timeLogs = app(TaskRepositoryInterface::class)->getByUser($userId);

        $projectNames = [
            'website-redesign'    => 'Website Redesign',
            'mobile-app'          => 'Mobile App Development',
            'backend-api'         => 'Backend API Integration',
            'marketing-campaign'  => 'Marketing Campaign',
        ];

    return view('time', [
        'timeLogs' => $timeLogs,
        'projectNames'=> $projectNames,
        'pageTitle' => 'Add Tasks'
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $request->validate([]);

        $userId   = Auth::id();
        $date     = $request->work_date;
        $time     = $request->time_spent;

        // Convert HH:MM to minutes
        [$hours, $minutes] = explode(':', $time);
        $minutesSpent = ($hours * 60) + $minutes;

        if ($minutesSpent > 600) {
            return back()->withErrors(['time_spent' => 'A single task cannot exceed 10 hours.'])->withInput();
        }
        // Leave check
        if (app(LeaveRepositoryInterface::class)->existsForDate($userId, $date)) {
            return back()->withErrors(['work_date' => 'Leave exists on this date.'])->withInput();
        }
        $totalMinutes = app(TaskRepositoryInterface::class)->getTotalMinutesByDate($userId, $date);

        if ($totalMinutes + $minutesSpent > 600) {
            return back()->withErrors(['time_spent' => 'Total for the day cannot exceed 10 hours.'])->withInput();
        }

        $data = $request->validated();
        $data['user_id'] = $userId;
        $data['time_spent'] = $minutesSpent;

        app(TaskRepositoryInterface::class)->create($data);

        return redirect()->back()->with('success', 'Task added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
