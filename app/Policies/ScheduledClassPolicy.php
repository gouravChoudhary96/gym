<?php

namespace App\Policies;

use App\Models\ScheduledClass;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ScheduledClassPolicy
{
    public function delete(User $user, ScheduledClass $ScheduledClass)
    {
        return $user->id === $ScheduledClass->instructor_id
            && $ScheduledClass->date_time > now()->addHours(2);
    }
}
