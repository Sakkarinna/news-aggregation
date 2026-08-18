<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class FollowController extends Controller
{
    /**
     * Handle follow/unfollow logic for user or article.
     */
    public function follow(Request $request, $type, $id)
{
    $user = Auth::user();

    // Resolve the model (User or Article)
    $model = $this->resolveModel($type, $id);

    if (!$model) {
        return redirect()->back()->withErrors(['error' => 'Invalid follow target']);
    }

    // Check if the user is already following
    $isFollowing = Follow::where('user_id', $user->id)
        ->where('followable_id', $model->id)
        ->where('followable_type', get_class($model))
        ->exists();

    if ($isFollowing) {
        // Unfollow the model
        Follow::where('user_id', $user->id)
            ->where('followable_id', $model->id)
            ->where('followable_type', get_class($model))
            ->delete();
    } else {
        // Follow the model
        Follow::create([
            'user_id' => $user->id,
            'followable_id' => $model->id,
            'followable_type' => get_class($model),
        ]);
    }

    return redirect()->back();
}


    /**
     * Resolve the model to follow.
     */
    protected function resolveModel($type, $id)
    {
        if ($type === 'user') {
            return User::find($id);
        } elseif ($type === 'article') {
            return Article::find($id);
        }

        return null; // Invalid type
    }
}
