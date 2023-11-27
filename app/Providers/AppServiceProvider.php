<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Constants\{TaskTypes, Priorities};
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectTaskTimer;
use Carbon\Carbon;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::share('taskTypes', TaskTypes::getTaskTypes());
        View::share('taskPriorities', Priorities::getPriorities());
        View::composer('*', function($view){
            if(Auth::check()){
                $user_id = Auth::user()->id;
                $projectTimerCount = ProjectTaskTimer::where('user_id',$user_id)
                ->whereNull('end_time')->count();
                $projectTimer = ProjectTaskTimer::where('user_id',$user_id)
                ->whereNull('end_time')->first();
                $view->with('notificationCount', Auth::user()->unreadNotifications()->count());
                $view->with('isTimerRunning', ($projectTimerCount==1?true:false));
                $view->with('runningTimerTask', $projectTimer);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
