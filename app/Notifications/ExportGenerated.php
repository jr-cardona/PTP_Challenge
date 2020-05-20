<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ExportGenerated extends Notification
{
    use Queueable;

    protected $report;

    /**
     * Create a new notification instance.
     *
     * @param $report
     */
    public function __construct($report)
    {
        $this->report = $report;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting($notifiable->name . ',')
            ->subject('Un usuario realizó una exportación')
            ->line('El usuario ' . $this->report->user->fullname . ' acaba de realizar una exportación.')
            ->line('Fecha y hora: ' . $this->report->created_at)
            ->line('Id del reporte: ' . $this->report->id);
    }
}
