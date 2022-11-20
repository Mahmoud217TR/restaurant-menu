<?php

namespace App\Actions\API;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Facades\Hash;
use Spatie\QueueableAction\QueueableAction;

class DeleteCategoryAction
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
    public function execute(Category $category)
    {
        $category->items()->delete();
        $category->subCategories()->delete();
        $category->delete();
    }
}
