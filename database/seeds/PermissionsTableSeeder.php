<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
    	
    	$createPost = new Permission();
    	$createPost->name = 'create-post';
    	$createPost->display_name = 'Create posts';//optional
    	//Allow user to...
    	$createPost->description = 'Create new post';
    	$createPost->save();


    	$editPost = new Permission();
    	$editPost->name = 'edit-post';
    	$editPost->display_name = 'Edit posts';//optional
    	//Allow user to...
    	$editPost->description = 'Edit existing post';
    	$editPost->save();

    	$deletePost = new Permission();
    	$deletePost->name = 'delete-post';
    	$deletePost->display_name = 'Delete posts';//optional
    	//Allow user to...
    	$deletePost->description = 'Deletee existing post';
    	$deletePost->save();
    }
}
