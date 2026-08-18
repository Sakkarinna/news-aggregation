<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships

    /**
     * Get all the articles of the user.
     *
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get all the likes of the user.
     *
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get all the comments of the user.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Users that this user is following.
     */
    public function followings()
    {
        return $this->morphToMany(
            User::class,
            'followable',
            'follows',
            'user_id',
            'followable_id'
        )->withPivot('followable_type');
    }


    /**
     * Articles that this user is following.
     */
    public function followedArticles()
    {
        return $this->morphedByMany(
            Article::class,
            'followable',
            'follows',
            'user_id',
            'followable_id'
        )->withPivot('followable_type');
    }


    /**
     * Users who follow this user.
     */
    public function followers()
    {
        return $this->morphToMany(User::class, 'followable', 'follows', 'followable_id', 'user_id');
    }



    /**
     * Check if the user has liked an article.
     *
     * @param Article $article
     * @return bool
     */
    public function hasLikedArticle(Article $article): bool
    {
        return $this->likes()->where('likeable_id', $article->id)->where('likeable_type', Article::class)->exists();
    }

    /**
     * Check if the user has liked a comment.
     *
     * @param Comment $comment
     * @return bool
     */
    public function hasLikedComment(Comment $comment): bool
    {
        return $this->likes()->where('likeable_id', $comment->id)->where('likeable_type', Comment::class)->exists();
    }
    public function scopeWithoutDeleted($query)
    {
        return $query->whereNotIn('email', function ($query) {
            $query->select('email')->from('deleted_users');
        });
    }
}
