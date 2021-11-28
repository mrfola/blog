<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $posts = $post->paginate(15);

        /**$response = 
            [
                'data' => $posts['data'],
                'total_count' => $posts['total'],
                'limit' => $posts['per_page'],
                'pagination' => 
                    [
                        'next_page' => $posts['next_page_url'],
                        'current_page' => $posts['current_page']
                    ]
            ]; **/
            //I don't know why the above code isn't working. When I try to access any value inside the $posts array, it returns null
        return $posts;
           
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation_rules =  [
            "content" => "required | min:1",
            "title" => "required | min:1",
            "status" => "required | in:draft,published", 
            "user_id" => "required | exists:users,id"
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if($validator->fails())
        {
            $response = ["errors" => $validator->errors()];
            $status_code = Response::HTTP_BAD_REQUEST;
            return new JsonResponse($response, $status_code);
        }

        $post = Post::create($request->all());
        return 
        [
            "data" => $post
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if(!$post)
        {
            $response = ["errors" => "Post not found"];
            $status_code = Response::HTTP_NOT_FOUND;
          return new JsonResponse($response, $status_code);
        }
        return $post;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $post = Post::find($id);
        if(!$post)
        {
            $response = ["errors" => "Post not found"];
            $status_code = Response::HTTP_NOT_FOUND;
            return new JsonResponse($response, $status_code);

        }else
        {
            $validation_rules =  [
                "content" => "min:1",
                "title" => "min:2",
                "status" => "in:draft,published", 
            ];

            $validator = Validator::make($request->all(), $validation_rules);

            if($validator->fails())
            {
                $response = ["errors" => $validator->errors()];
                $status_code = Response::HTTP_BAD_REQUEST;
                return new JsonResponse($response, $status_code);
            }
            
            Post::where('id', $id)->update($request->all());
            $updated_post = $this->show($id);
            return $updated_post;
        }

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if(!$post)
        {
            $response = ["errors" => "Post not found"];
            $status_code = Response::HTTP_NOT_FOUND;
            return new JsonResponse($response, $status_code);

        }

        $delete_post = $post->delete($id);
        if($delete_post)
        {
            return  ['message' => 'deleted successfully', 'post_id' => $post->id];
        }
    }
}
