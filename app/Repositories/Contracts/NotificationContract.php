<?php

namespace App\Repositories\Contracts;

interface NotificationContract extends BaseContract
{
    public function sendDriversNotification($drivers, array $data): void;

    public function notify($user, $notification, $model): void;

    public function orderIssueAssignedEmployeeNotify($issue, $user_id);
}

