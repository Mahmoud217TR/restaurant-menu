<?php

namespace App\Models;

use App\Enums\Currency;
use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Money $price
 */
class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount',
        'currency',
        'price',
        'category_id',
    ];

    protected $attribute = [
        'currency_id' => 'USD',
    ];

    public $casts = [
        'currency' => Currency::class,
        'price' => MoneyCast::class.':currency',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function getCalculatedDiscountAttribute(){
        return $this->discount??$this->category->calculated_discount;
    }

    public function getOwnerAttribute(){
        return $this->category->owner;
    }

    public function isOwner(User $user){
        return $this->category->isOwner($user);
    }

    public function getCalculatedPriceAttribute(){
        return $this->price->subtract($this->price->multiply($this->calculated_discount/100));
    }
}
