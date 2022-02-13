<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Feedback;

class FeedbackPolicy{
    
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function sameuser(User $user, Feedback $feedback){

        return $user->id === $feedback->user_id;
    }
}
