<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $owner = new Role();
        $owner->name = "owner";
        $owner->display_name = "Product Owner";//optional
        $owner->description = 'Product owner is the owner of a given projects';//optional
        $owner->save();

        $owner = new Role();
        $owner->name = "admin";
        $owner->display_name = "Admin Owner";//optional
        $owner->description = 'Admin is the administrator of a given projects';//optional
        $owner->save();

    }
}
