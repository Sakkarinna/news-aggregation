<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'content', 'category_id', 'pic_url', 'pic_path', 'vid_url', 'vid_path',
    ];


    // Relationships

    public function user()
{
    return $this->belongsTo(User::class)->withDefault([
        'name' => 'Anonymous',
        'profile_picture' => asset('images/default-profile.png'),
    ]);
}


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function followers()
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    // Custom Methods

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function addLike(User $user)
    {
        if (!$this->isLikedBy($user)) {
            $this->likes()->create(['user_id' => $user->id]);
        }
    }

    public function removeLike(User $user)
    {
        $this->likes()->where('user_id', $user->id)->delete();
    }


}
