<?php

namespace App\Interfaces;

interface TaskRepositoryInterface
{
   public function getTotalMinutesByDate($userId, $date);
   public function create(array $data);
   public function getByUser($userId);
   public function getRecentLogs($userId, $limit = 15);
}
