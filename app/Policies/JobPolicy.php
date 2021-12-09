<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Job;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy{

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function sameuser(User $user, Job $job){

        return $user->id === $job->user_id;
    }
}
