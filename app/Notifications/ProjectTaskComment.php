<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ProjectTaskComment as ProjectTaskCommentModel;
class ProjectTaskComment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $projectTaskComment;
    public function __construct(ProjectTaskCommentModel $projectTaskComment)
    {
        $this->projectTaskComment = $projectTaskComment;
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
        return [
            'user_id' => $this->projectTaskComment->user_id,
            'comment_id' => $this->projectTaskComment->id,
            'task_id' => $this->projectTaskComment->project_task_id,
            'project_id' => $this->projectTaskComment->project_id,
            'text' =>  view('notifications.li',[
                'taskComment' => $this->projectTaskComment,
                'text' => 'Commented on Task <a target="_blank" href="'.route('dashboard', [
                    'opentaskmodal' => 1,
                    'project_id' => $this->projectTaskComment->project_id,
                    'task_id' => $this->projectTaskComment->project_task_id
                ]).'">'.$this->projectTaskComment->task->title.'</a>'
            ])->render()
        ];
    }
}
