<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\ActivityLogService;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Post Construct
     *
     * @param \App\Services\PostService $postService
     */
    public function __construct(private readonly PostService $postService) {}

    /**
     * Retrieve Posts
     *
     * @return void
     */
    public function index() : JsonResponse
    {
        return response()->json(Post::with('category')->paginate(10));
    }

    /**
     * Show Func
     *
     * @param [type] $id
     *
     * @return void
     */
    public function show($id) : JsonResponse {
        $post = $this->findPostOrFail($id);
        
        // Log activity
        ActivityLogService::log('READ', class_basename(Post::class), $post->id, null);

        return response()->json([
            'success' => true,
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
        $post = $this->findPostOrFail($id);

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
        $post = $this->findPostOrFail($id);

        // delete post
        $deletePost = $this->postService->deletePost($id);

        // Log activity
        ActivityLogService::log('DELETE', class_basename(Post::class), $post->id, null);

        return response()->json([
            'success' => true,
            'message' => 'Post Deleted.',
            'post' => $deletePost
        ]);
    }

    private function findPostOrFail($id)
    {
        $post = Post::find($id);
        if (!$post) {
            abort(response()->json([
                'success' => false,
                'message' => 'Post Not Found',
            ], 404));
        }
        return $post;
    }
}
