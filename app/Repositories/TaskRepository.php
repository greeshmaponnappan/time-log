<?php

namespace App\Repositories;

use App\Models\TimeLog;
use Illuminate\Support\Facades\Log;

class TaskRepository
{
    public function getTotalMinutesByDate($userId, $date)
    {
        return TimeLog::where('user_id', $userId)
            ->where('work_date', $date)
            ->sum('time_spent');
    }
    public function create(array $data)
    {
        return TimeLog::create($data);
    }
    public function getByUser($userId)
    {
        return TimeLog::where('user_id', $userId)
            ->get();
    }
    public function getRecentLogs(int $userId, int $limit = 15)
    {
        return TimeLog::where('user_id', $userId)
            ->latest('work_date')
            ->take($limit)
            ->get();
    }


}
