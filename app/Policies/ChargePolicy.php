<?php

namespace App\Policies;

use App\Models\Compony;
use App\Models\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChargePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Compony  $compony
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        return $user->hasPermissionTo('Read-charge') ? $this->allow() : $this->deny();
    }

 

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Compony  $compony
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        return $user->hasPermissionTo('Create-charge') ? $this->allow() : $this->deny();
    }

  

}
