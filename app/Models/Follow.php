<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'followable_id', 'followable_type'];

    /**
     * Get the user that is following.
     *
     * @return BelongsTo
     */
    /**
     * Define the followable (polymorphic) relationship.
     */
    public function followable()
    {
        return $this->morphTo();
    }
    /**
     * Define the user relationship.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
