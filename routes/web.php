<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\{GoogleApiController, UserController, DashboardController, CronController, ProjectTaskCollaboratorController, ProjectTaskSubtaskController, ProjectTaskCommentController, ProjectGridController, ReportController, ProjectInviteController, NotificationController, QuoteController, InboxController, ProfileController, ProjectController, ProjectTaskController, ProjectTaskTimerController, WorkforceTaskController};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/invitation/{projectInvite}', [ProjectInviteController::class,'index'])->name('project.invite');
Route::post('/invitation/{projectInvite}', [ProjectInviteController::class,'inviteAccept'])->name('project.invite.accept');
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class,'index'])->name('login');
    Route::post('/login', [LoginController::class,'authenticate'])->name('login.check');
});

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::middleware(['isadmin'])
    ->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });
    Route::prefix('ggl')->group(function () {
        Route::post('/set-token', [GoogleApiController::class, 'setToken'])->name('google.setToken');
        Route::get('/check-token', [GoogleApiController::class, 'checkToken'])->name('google.checkToken');
        Route::get('/forget-token', [GoogleApiController::class, 'forgetToken'])->name('google.forgetToken');
    });
    Route::get('/reports', [ReportController::class,'index'])->name('reports');
    Route::get('/reports-data', [ReportController::class,'workforceTimers'])->name('reports.data');
    Route::get('/inbox', [InboxController::class,'index'])->name('inbox');
    Route::get('/notifications', [NotificationController::class,'index'])->name('notifications');
    Route::get('/notifications/delete/{id}', [NotificationController::class,'destroy'])->name('notifications.destroy');
    Route::get('/notifications/important/{id}', [NotificationController::class,'markImportant'])->name('notifications.important');
    Route::get('/profile', [ProfileController::class,'profile'])->name('profile');
    Route::get('/users/{user}', [ProfileController::class,'user'])->name('user');
    Route::get('/users/tasks/{user}', [ProfileController::class,'tasks'])->name('user.tasks');
    Route::get('users', [UserController::class, 'listing'])->name('users.index');
    Route::post('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class,'changePassword'])->name('profile.changepassword');
    Route::resource('quotes', QuoteController::class)->except([
        'index', 'update', 'edit',
    ]);
    Route::post('/quotes/{quote?}/comments', [QuoteController::class,'postComments'])->name('quotes.postComments');
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class,'index'])->name('dashboard');
        Route::get('/birthday-calendar', [DashboardController::class,'birthdayCalendar'])->name('dashboard.birthdays');
        Route::get('/get-tasks', [DashboardController::class,'getTasks'])->name('dashboard.tasks');
        Route::get('/projects', [DashboardController::class,'getProjects'])->name('dashboard.projects');
        Route::get('/today-quotes', [DashboardController::class,'todayQuotes'])->name('dashboard.todayQuotes');
    });
    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
        Route::post('/', [ProjectController::class, 'store'])->name('projects.store');
        Route::post('/{project}/update-name', [ProjectController::class, 'update'])->name('projects.update');
        Route::get('/{project}/board', [ProjectController::class, 'board'])->name('projects.board');
        Route::get('/{project}/list', [ProjectController::class, 'list'])->name('projects.list');
        Route::get('/{project}/files', [ProjectController::class, 'files'])->name('projects.files');
        Route::post('/{project}/invite', [ProjectController::class, 'invite'])->name('projects.invite');
        Route::get('/{project}/invite/{user}', [ProjectController::class, 'userInvite'])->name('projects.userInvite');
        Route::get('/{project}/grids', [ProjectGridController::class, 'index'])->name('projects.grids.index');
        Route::get('/{project}/grids/order/{grid}/{type}', [ProjectGridController::class, 'orderUpdate'])->name('projects.grids.order.update');
        Route::post('/{project}/grid/store', [ProjectGridController::class, 'store'])->name('projects.grids.store');
        Route::post('/{project}/grid/edit/{grid}', [ProjectGridController::class, 'edit'])->name('projects.grids.edit');
        Route::post('/{project}/tasks', [ProjectTaskController::class, 'store']);
        Route::get('/{project}/tasks/workforce-assign', [WorkforceTaskController::class, 'index'])->name('workforce.tasks.assign');
        Route::post('/{project}/tasks/workforce-assign', [WorkforceTaskController::class, 'store'])->name('workforce.tasks.store');
        Route::post('/{project}/tasks/otherproject', [ProjectTaskController::class, 'storeOtherProject']);
        Route::get('/{project}/tasks/{projectTask}/completeToggle', [ProjectTaskController::class, 'completeToggle']);
        Route::post('/{project}/tasks/{projectTask}/updateTaskTitle', [ProjectTaskController::class, 'updateTaskTitle']);
        Route::get('/{project}/tasks/{projectTask}/collaborators', [ProjectTaskCollaboratorController::class, 'index']);
        Route::post('/{project}/tasks/{projectTask}/collaborators', [ProjectTaskCollaboratorController::class, 'store'])->name('project.task.collaborators.store');
        Route::post('/{project}/tasks/{projectTask}/subtasks/store', [ProjectTaskSubtaskController::class, 'store']);
        Route::post('/{project}/tasks/{projectTask}/subtasks/update/{subTask}', [ProjectTaskSubtaskController::class, 'update']);
        Route::delete('/{project}/tasks/{projectTask}/subtasks/{subTask}', [ProjectTaskSubtaskController::class, 'destroy']);
        Route::get('/{project}/tasks/{projectTask}', [ProjectTaskController::class, 'get']);
        Route::post('/{project}/tasks/{projectTask}/gridUpdate', [ProjectTaskController::class, 'gridUpdate']);
        Route::post('/{project}/tasks/{projectTask}/priorityUpdate', [ProjectTaskController::class, 'priorityUpdate']);  
        Route::post('/{project}/tasks/{projectTask}/dueDateUpdate', [ProjectTaskController::class, 'dueDateUpdate']);        
        Route::post('/{project}/tasks/{projectTask}/comments', [ProjectTaskCommentController::class, 'store']);
    });
    Route::get('/my-tasks', [ProjectTaskController::class, 'mytasks'])->name('mytasks');
    Route::get('/my-tasks/list', [ProjectTaskController::class, 'mytasksList'])->name('mytasks.list');
    Route::get('/projects/{project}/tasks/{projectTask}/timers', [ProjectTaskTimerController::class, 'setTimer']);

    Route::get('/logout', [LoginController::class,'logout'])->name('logout');
});

Route::get('/', function(){
    return redirect()->route('login');
});
Route::prefix('cron')->group(function () {
    Route::get('/task-status-notifications', [CronController::class, 'taskStatusNotifications']);
});