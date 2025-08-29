<?php

namespace App\Repositories;

use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveRepository
{
    /**
     * Create a new class instance.
     */
    public function applyLeave(array $data)
    {
        $data['user_id']  = Auth::id();
        $data['applied_date'] = Carbon::now();
        return Leave::create($data);
    }
    public function hasWorkReportForDates($userId, $startDate, $endDate): bool
    {
        return DB::table('time_logs')
            ->where('user_id', $userId)
            ->whereBetween('work_date', [$startDate, $endDate])
            ->exists();
    }
    public function getUserLeaves($userId){
        return Leave::where('user_id', $userId)
                    ->orderBy('start_date', 'desc')
                    ->get();
    }
    public function existsForDate($userId, $date)
    {
        return Leave::where('user_id', $userId)
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->exists();
    }
    public function countByDate(int $userId, string $date): int
    {
        return Leave::where('user_id', $userId)
            ->whereDate('applied_date', $date)
            ->count();
    }
}
