<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\comment;
use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(post $post){
        $comments = comment::where('post_id', $post->id)->get();
        return view('comment.index', ['comments' => $comments], ['post' => $post]);
        
    }

    public function create(post $post){
        // dump($post->user_id);
        return view('comment.create', ['post' => $post]);
    }


    public function store(Request $request, post $post){
        // dd($request);
        $data = $request->validate([
            'post_id' => 'required',
            'comment' => 'required'
        ]);
        $data['user_id'] = Auth::user()->id;
        $newComment = Comment::create($data);
        return redirect(route('post.index'));
        // return redirect(route('comment.index', ['post' => $post]))->with('success', 'Comment Added Successfully!');
    }

    public function destroy(comment $comment){
        $comment->delete();
        return redirect(route('post.index'));
        // return redirect(route('comment.index', ['post' => $post]))->with('success', 'Comment Deleted Successfully');
    }

    public function showComment(Request $request){
        $post_id = $request->input('id');
        // dd($post_id);
        $comments =  comment::where('post_id', $post_id)->orderBy('created_at', 'desc')->get();
        // dd($comments->isEmpty());
        if($comments->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'There are no comments added',
            ]);
        }

        foreach($comments as $comment){
            if($comment){
                $user = User::where('id', $comment->user_id)->first();
                // dd($user);
               $datacomment[] = [
                'username' => $user->username ? $user->username : $user->name,
                'profile_pic' => $user->profile_pic ? json_decode($user->profile_pic)[0] : '',
                'comment' => $comment->comment,
               ]; 
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched all comments',
            'comments' => $datacomment,
        ]);

    }
    public function createComment(Request $request) {
        $data = $request->validate([
            'user_id' => 'required',
            'post_id' => 'required',
            'comment' => 'required',
            'created_at' => 'required'
        ]);

        try{
            $newcomment = comment::create([
                'user_id' => 'required',
                'post_id' => 'required',
                'comment' => 'required',
                'created_at' => 'required'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment created successfully',
                'data' => [
                    'comment' => $newcomment,
                ],
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create comment. Please try again later.',
            ]);
        }
    }

}
