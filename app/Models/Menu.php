<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function getOwnerAttribute(){
        return $this->user;
    }

    public function isOwner(User $user){
        return $this->owner->id == $user->id;
    }

    public function mainCategories(){
        return $this->categories()->mainCategories();
    }
}
