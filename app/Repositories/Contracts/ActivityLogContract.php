<?php

namespace App\Repositories\Contracts;

interface ActivityLogContract extends BaseContract
{
    public function getModulesActions(): array;
}

