<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    /**
     * Get all of the comments for the MenuItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subMenu(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->subMenu()->with('subMenu');
    }

}
