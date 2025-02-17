<?php

namespace App\Notifications;

use App\Models\AdminAssignTask;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssginmentNotification extends Notification
{
    use Queueable;


    private $task;
    protected $token;
    /**
     * Create a new notification instance.
     */
    public function __construct(AdminAssignTask $task, string $token = null)
    {
        $this->task = $task;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        if ($this->token != null)
            // currectly its a local link but change it in future
            $url = url("http://localhost:5173/tasks/assign/{$this->task->id}/{$this->token}");
        return (new MailMessage)
            ->subject('New Task Assigned')
            ->greeting("Dear {$notifiable->name},")
            ->line("You have a new task assigned by the admin.")
            ->line('Here are the details:')
            ->line('Task Name: ' . $this->task->title)
            // ->line('Deadline: ' . $this->task->deadline) 
            ->line('Deadline: ' . $this->task->deadline->format('Y-m-d H:i:s'))
            ->line('Please log in to your account to view and manage this task.')
            ->action('Accept Task', $url)
            ->line("Thank you for using " . config('app.name') . " app!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'task_assignment_notification',
            'text' => 'You have a new task assigned by the admin, check your mailbox for more details.',
        ];
    }
}
