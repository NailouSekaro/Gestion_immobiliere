<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SecurityAlertNotification extends Notification
{
    use Queueable;

    public $alertType;
    public $ipAddress;
    public $deviceInfo;

    public function __construct($alertType, $ipAddress = null, $deviceInfo = null)
    {
        $this->alertType = $alertType;
        $this->ipAddress = $ipAddress;
        $this->deviceInfo = $deviceInfo;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Alerte de sécurité - ' . config('app.name'))
            ->view('emails.security-alert', [
                'user' => $notifiable,
                'alertType' => $this->alertType,
                'ipAddress' => $this->ipAddress,
                'deviceInfo' => $this->deviceInfo
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'alert_type' => $this->alertType,
            'ip_address' => $this->ipAddress,
            'device_info' => $this->deviceInfo,
            'timestamp' => now()
        ];
    }
}
