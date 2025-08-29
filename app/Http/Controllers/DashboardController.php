<?php

namespace App\Http\Controllers;

use App\Repositories\LeaveRepository;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TaskRepository $taskRep, LeaveRepository $leaveRepo)
    {
        $userId = Auth::id();
        $today = now()->toDateString();

        $totalMinutes = app(TaskRepository::class)->getTotalMinutesByDate($userId, $today);

        $totalHoursToday = floor($totalMinutes / 60) . 'h ' . ($totalMinutes % 60) . 'm';

        // Leave applications for today
        $leaveCountToday = app(LeaveRepository::class)->countByDate($userId, $today);

        // Recent project time logs
        $timeLogs = app(TaskRepository::class)->getRecentLogs($userId);

        $projectNames = [
            'website-redesign'    => 'Website Redesign',
            'mobile-app'          => 'Mobile App Development',
            'backend-api'         => 'Backend API Integration',
            'marketing-campaign'  => 'Marketing Campaign',
        ];

        return view('dashboard', compact(
            'totalMinutes',
            'totalHoursToday',
            'leaveCountToday',
            'timeLogs',
            'projectNames'
        ));

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
    public function store(Request $request)
    {
        //
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
