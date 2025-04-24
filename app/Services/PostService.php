<?php

namespace App\Services;

use App\Models\Post;

class PostService{

    public function createPost(array $data){
        // business logic here
        return Post::create($data);
    }

    public function updatePost(array $data , $id){
        // business logic here
        $newPost = Post::find($id);
        return $newPost->update($data);
    }

    public function deletePost($id){
        $deletePost = Post::findOrFail($id);
        $deletePost->delete();
        return $deletePost;
    }
}