<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\{ProjectTask, User};
class TaskNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $date = date('Y-m-d');
        $today = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date',$date)
        ->where('user_id', $this->user->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority')
        ->count();
        $upComming = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '>', $date)
        ->where('user_id', $this->user->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority')
        ->count();
        $overdue = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '<', $date)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') <= 6")
        ->where('user_id', $this->user->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority')
        ->count();
        $stopped = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '<', $date)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') > 6")
        ->where('user_id', $this->user->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority')
        ->count();
        return [
            'text' =>  view('notifications.taskNotificaiton',[
                'stopped' => $stopped,
                'overdue' => $overdue,
                'upComming' => $upComming,
                'today' => $today,
                'user' => $this->user
            ])->render()
        ];
    }
}
