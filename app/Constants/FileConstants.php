<?php

namespace App\Constants;

use App\Traits\ConstantsTrait;

/**
 * model files constants for upload
 * constant stamp (FILE_TYPE_{model name}_{file name})
 */
enum FileConstants: string
{
    use ConstantsTrait;
    case FILE_TYPE_USER_AVATAR = "user_avatar";
    case FILE_TYPE_DRIVER_AVATAR = "driver_avatar";
}
