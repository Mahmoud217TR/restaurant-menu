<?php

namespace App\Actions\API;

use App\Models\Item;
use Spatie\QueueableAction\QueueableAction;

class CreateItemAction
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
    public function execute($data)
    {
        return Item::create($data);
    }
}
