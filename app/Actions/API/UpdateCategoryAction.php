<?php

namespace App\Actions\API;

use App\Models\Category;
use App\Models\Menu;
use Spatie\QueueableAction\QueueableAction;

class UpdateCategoryAction
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
    public function execute(Category $category, $data)
    {
        $category->update($data);
        return $category;
    }
}
