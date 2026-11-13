<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // ←★繋げるためのおまじない

class Product extends Model
{
    // ★ここに「季節の棚と何個でも繋がれる、魔法のポケット」を書き足すよ！
    protected $fillable = ['name', 'price', 'image', 'description'];
    
    public function seasons(): BelongsToMany
    {
        return $this->belongsToMany(Season::class);
    }
}
