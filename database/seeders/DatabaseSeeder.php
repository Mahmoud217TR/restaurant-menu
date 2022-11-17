<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Item;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->forUser($user)->create();
        Category::factory(3)->forMenu($menu)->create()->each(function($category){
            Item::factory(3)->forCategory($category)->create();
        });
    }
}
