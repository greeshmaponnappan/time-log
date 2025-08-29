<?php

namespace App\Providers;

use App\Interfaces\LeaveRepositoryInterface;
use App\Interfaces\LoginInterface;
use App\Interfaces\TaskRepositoryInterface;
use App\Repositories\LeaveRepository;
use App\Repositories\LoginRepository;
use App\Repositories\TaskRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(LoginInterface::class, LoginRepository::class);
        $this->app->bind(LeaveRepositoryInterface::class, LeaveRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
