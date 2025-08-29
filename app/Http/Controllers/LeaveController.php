<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveRequest;
use App\Repositories\LeaveRepository;
use App\Interfaces\LeaveRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $leaves = app(LeaveRepositoryInterface::class)->getUserLeaves($userId);
        return view('leave', [
            'leaves'=>$leaves,
            'pageTitle' => 'Leave Requests'
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
    public function store(StoreLeaveRequest $request)
    { //dd($request->validated());
        $userId = Auth::id();

        if (app(LeaveRepositoryInterface::class)->hasWorkReportForDates($userId, $request->start_date, $request->end_date)) {
            return back()->withErrors(['leave' => 'You already have work reports on selected dates, so you cannot apply leave.']);
        }

        app(LeaveRepositoryInterface::class)->applyLeave($request->validated());

        return redirect()->back()->with('success', 'Leave applied successfully!');
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
