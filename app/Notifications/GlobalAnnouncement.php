<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class GlobalAnnouncement extends Notification
{

    public function via($notifiable)
    {
        return ['database', TelegramChannel::class];
    }

    public function toArray($notifiable)
    {
        return [
            $notifiable->text
        ];
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to('@ptm_announcements')
            ->content($notifiable->text);
    }
}
