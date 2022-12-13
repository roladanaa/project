<?php

namespace App\Policies;

use App\Models\Compony;
use App\Models\PayPoint;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayPointPolicy
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
        return $user->hasPermissionTo('Read-paypoint') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Compony  $compony
     * @param  \App\Models\PayPoint  $payPoint
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, PayPoint $payPoint)
    {
        return $user->hasPermissionTo('Show-paypoint') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Compony  $compony
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        return $user->hasPermissionTo('Create-paypoint') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Compony  $compony
     * @param  \App\Models\PayPoint  $payPoint
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, PayPoint $payPoint)
    {
        return $user->hasPermissionTo('Update-paypoint') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Compony  $compony
     * @param  \App\Models\PayPoint  $payPoint
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, PayPoint $payPoint)
    {
        return $user->hasPermissionTo('Delete-paypoint') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Compony  $compony
     * @param  \App\Models\PayPoint  $payPoint
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore($user, PayPoint $payPoint)
    {
        return $user->hasPermissionTo('Delete-paypoint') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Compony  $compony
     * @param  \App\Models\PayPoint  $payPoint
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete($user, PayPoint $payPoint)
    {
        return $user->hasPermissionTo('Delete-paypoint') ? $this->allow() : $this->deny();
    }

    public function showReport($user, PayPoint $payPoint)
    {
        return $user->hasPermissionTo('Show-report') ? $this->allow() : $this->deny();
    }

    
}
