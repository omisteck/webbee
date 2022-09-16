<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    /**
     * Get all of the workshops for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workshops(): HasMany
    {
        return $this->hasMany(Workshop::class);
    }
}
