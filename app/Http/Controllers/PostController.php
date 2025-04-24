<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\ActivityLogService;
use App\Services\PostService;

class PostController extends Controller
{
    private $postService;

    /**
     * Post Construct
     *
     * @param \App\Services\PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Retrieve Posts
     *
     * @return void
     */
    public function index(){
        return response()->json(Post::with('category')->paginate(10));
    }

    /**
     * Show Func
     *
     * @param [type] $id
     *
     * @return void
     */
    public function show($id){
        $post = Post::find($id);
        if(!$post){
            return $this->fireError("Post Not Found" , 404);
        }
        
        // Log activity
        ActivityLogService::log('READ', class_basename(Post::class), $post->id, null);

        return response()->json([
            'status' => true,
            'message' => 'Post retrieved successfully.',
            'post' => $post
        ]);
    }

    /**
     * Post Store
     *
     * @param \App\Http\Requests\PostRequest $postRequest
     *
     * @return void
     */
    public function store(PostRequest $postRequest){
        $post = $this->postService->createPost($postRequest->validated());

        // Log activity
        ActivityLogService::log('CREATE', class_basename(Post::class), $post->id, null);

        return response()->json([
            "success" => true,
            "message" => "Post Created.",
            "post" => $post
        ], 201);

    }

    /**
     * Post Update
     *
     * @param \App\Http\Requests\PostRequest $postRequest
     * @param [type] $id
     *
     * @return void
     */
    public function update(PostRequest $postRequest , int $id){
        $post = Post::find($id);

        if(!$post){
            return $this->fireError("Post Not Found" , 404);
        }
        $this->postService->updatePost($postRequest->validated() , $id);

        // Log activity with changed fields
        $changedFields = json_encode(array_diff_assoc($postRequest->validated(), $post->toArray()));

        if (!empty($changedFields)) {
            ActivityLogService::log('UPDATE', class_basename(Post::class), $post->id, $changedFields);
        }
        
        return response()->json([
            "success" => true,
            "message" => "Post Updated.",
            "post" => $post->fresh()
        ]);
    }

    /**
     * Post Destroy
     *
     * @param [type] $id
     *
     * @return void
     */
    public function destroy($id){
        $post = Post::find($id);
        if(!$post){
            return $this->fireError("Post Not Found" , 404);
        }

        // delete post
        $deletePost = $this->postService->deletePost($id);

        // Log activity
        ActivityLogService::log('DELETE', class_basename(Post::class), $post->id, null);

        return response()->json([
            'status' => true,
            'message' => 'Post Deleted.',
            'post' => $deletePost
        ]);
    }
}
