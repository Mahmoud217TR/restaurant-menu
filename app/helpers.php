<?php

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

if (!function_exists('extractItemIds')) {
	function extractItemIds(Collection $items){ 
		return $items->map(
            function($item){
                if($item instanceof Item){
                    return $item->id;
                }
            }
        );
	} 
} 