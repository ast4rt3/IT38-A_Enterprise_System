<?php

namespace App\Policies;

use App\Models\Checkpoint;
use App\Models\User;

class CheckpointPolicy
{
    public function update(User $user, Checkpoint $checkpoint)
    {
        return $user->id === $checkpoint->user_id;
    }

    public function delete(User $user, Checkpoint $checkpoint)
    {
        return $user->id === $checkpoint->user_id;
    }
} 