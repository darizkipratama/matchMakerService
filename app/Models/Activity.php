<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'activity',
        'from_profile_id',
        'to_profile_id'
    ];

    /**
     * Get the user that owns the Activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromProfile(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_profile_id');
    }

    /**
     * Get the user that owns the Activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toProfile(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_profile_id');
    }

}
