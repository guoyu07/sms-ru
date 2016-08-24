<?php

namespace NotificationChannels\SmsRu;

use Illuminate\Notifications\Notification;

class SmsRuChannel
{
    /** @var \NotificationChannels\SmsRu\SmsRuApi */
    protected $smsc;

    public function __construct(SmsRuApi $smsc)
    {
        $this->smsc = $smsc;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @throws  \NotificationChannels\SmsRu\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('smsru')) {
            return;
        }

        $message = $notification->toSmsRu($notifiable);

        if (is_string($message)) {
            $message = new SmsRuMessage($message);
        }

        $this->smsc->send($to, $message->toArray());
    }
}
