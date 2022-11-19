<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory;
    use NodeTrait;

    protected $fillable = [
        'title',
        'discount',
        'menu_id',
        'parent_id',
    ];

    public const SUB_CATEGORY_LEVEL = 4;

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function subCategories(){
        return $this->children();
    }

    public function isCategory(){
        return $this->isRoot();
    }

    public function isSubCategory(){
        return !$this->isCategory();
    }

    public function getCalculatedDiscountAttribute(){
        if($this->isCategory()){
            return $this->discount??$this->menu->discount;
        }else{
            return $this->discount??$this->parent->calculated_discount;
        }
    }

    public function assignCategory(Category $category){
        $category->update([
            'parent_id' => $this->id,
        ]);
    }

    public function assignItems(Collection $items){
        Item::whereIn('id',extractItemIds($items))->update([
            'category_id' => $this->id,
        ]);
    }

    public function getSubCategoryLevel(){
        return $this->ancestors()->count();
    }

    public function getOwnerAttribute(){
        return $this->menu->owner;
    }

    public function isOwner(User $user){
        return $this->menu->isOwner($user);
    }

    public function scopeMainCategories($query){
        $query->whereNull('parent_id');
    }

    public function scopeSubCategories($query){
        $query->whereNotNull('parent_id');
    }

    public function containsSubCategories(){
        return !$this->subCategories->isEmpty();
    }

    public function containsItems(){
        return !$this->items->isEmpty();
    }
}
