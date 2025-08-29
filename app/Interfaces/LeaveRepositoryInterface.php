<?php

namespace App\Interfaces;

interface LeaveRepositoryInterface
{
    public function applyLeave(array $data);
    public function getUserLeaves($userId);
    public function existsForDate($userId, $date);
    public function countByDate($userId, $today): int;
    public function hasWorkReportForDates($userId, $startDate, $endDate): bool;
}
