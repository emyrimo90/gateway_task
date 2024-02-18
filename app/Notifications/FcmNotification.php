<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use JsonException;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\Notification as NotificationChannel;

class FcmNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Model $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Model $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return [FcmChannel::class];
    }

    /**
     * @throws CouldNotSendNotification
     * @throws JsonException
     */
    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setData(json_decode($this->data->data, true, 512, JSON_THROW_ON_ERROR) ?? [])
            ->setNotification(NotificationChannel::create()
                ->setTitle($this->data->title)
                ->setBody($this->data->body))
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios'))
                    ->setPayload(['aps' => ['sound' => 'phz_dispatch_notification.mp3']]));
    }

}
