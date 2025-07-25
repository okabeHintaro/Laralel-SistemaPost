<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
   public function toggle(User $user)
{
    $authUser = Auth::user();

    if ($authUser->isFollowing($user)) {
        // Deixar de seguir
        $authUser->following()->detach($user->id);
    } else {
        // Seguir
        $authUser->following()->attach($user->id);

        // +4 ecos para o usuário seguido
        $user->addEcos(4);

        if ($user->id !== $authUser->id) {
            $user->notify('follow', [
                'from_user_id' => $authUser->id,
                'from_user_name' => $authUser->name,
            ]);
        }
    }

    return back();
}

}

