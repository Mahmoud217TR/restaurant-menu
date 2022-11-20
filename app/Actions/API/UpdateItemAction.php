<?php

namespace App\Actions\API;

use App\Models\Category;
use App\Models\Item;
use App\Models\Menu;
use Spatie\QueueableAction\QueueableAction;

class UpdateItemAction
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
    public function execute(Item $item, $data)
    {
        $item->update($data);
        return $item;
    }
}
