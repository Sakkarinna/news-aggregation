<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'article_id',
    ];

    /**
     * Get the user who wrote the comment.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the article that the comment is related to.
     *
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the likes associated with the comment.
     *
     * @return HasMany
     */
    public function likes()
{
    return $this->morphMany(Like::class, 'likeable');
}


    /**
     * Check if a user has liked this comment.
     *
     * @param int $userId
     * @return bool
     */
    public function isLikedBy(int $userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Add a like to this comment by a specific user.
     *
     * @param int $userId
     * @return Like
     */
    public function likeBy(int $userId): Like
    {
        return $this->likes()->create(['user_id' => $userId]);
    }

    /**
     * Remove a like from this comment by a specific user.
     *
     * @param int $userId
     * @return bool|null
     */
    public function unlikeBy(int $userId): ?bool
    {
        return $this->likes()->where('user_id', $userId)->delete();
    }

    public function likesCount(): int
    {
        return $this->likes()->count();
    }
}
