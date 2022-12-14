<?php

namespace App\Actions\API;

use App\Models\Category;
use App\Models\Menu;
use Spatie\QueueableAction\QueueableAction;

class CreateCategoryAction
{
    use QueueableAction;

    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(Menu $menu, $data, $parent_id = null)
    {
        $category = $menu->categories()->create($data);
        if($parent_id){
            Category::find($parent_id)->assignCategory($category);
        }
        return $category;
    }
}
