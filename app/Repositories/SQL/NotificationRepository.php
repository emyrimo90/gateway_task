<?php

namespace App\Repositories\SQL;

use App\Constants\NotificationRedirectTypeConstants;
use App\Models\Notification;
use App\Notifications\FcmNotification;
use App\Repositories\Contracts\NotificationContract;
use App\Repositories\Contracts\UserContract;

class NotificationRepository extends BaseRepository implements NotificationContract
{
    protected UserContract $userContract;

    /**
     * NotificationRepository constructor.
     * @param Notification $model
     */
    public function __construct(Notification $model)
    {
        parent::__construct($model);
        $this->userContract = app(UserContract::class);

    }

    public function sendDriversNotification($drivers, array $data): void
    {
        $notification = $this->create($data);
        if (!is_array($drivers)){
            $drivers = [$drivers];
        }
        foreach ((array)$drivers as $driver)
        {
            $this->notify($driver, $notification, 'driver');
        }
    }

    public function notify($user, $notification, $model): void
    {
        $user->notifications()->attach($notification);
        if ($model === 'driver' && count($user->getDeviceTokens())){
            $user->notify(new FcmNotification($notification));
        }
    }


    public function orderIssueAssignedEmployeeNotify($issue, $user_id)
    {
        $notification = $issue->notifications()->create([
            'title' => 'New Issue',
            'body' => "issue with id: $issue->id assigned to you",
            'redirect_type' => NotificationRedirectTypeConstants::NOTIFICATION_REDIRECT_TYPE_ISSUE->value
        ]);
        $user = $this->userContract->findOrFail($user_id);
        $user->notifications()->attach($notification);
        return $notification;
    }

}
