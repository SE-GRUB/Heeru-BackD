<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\comment;
use App\Models\post;
use App\Models\comment_reply;
use App\Models\User;
use Illuminate\Http\Request;

class CommentReplyController extends Controller
{
    public function index(comment $comment){
        $comment_replies = comment_reply::where('comment_id', $comment->id)->get();
        return view('comment_reply.index', ['comment_replies' => $comment_replies], ['comment' => $comment]);
    }

    public function create(comment $comment){
        // dump($post->user_id);
        return view('comment_reply.create', ['comment' => $comment]);

    }

    public function store(Request $request, post $post, comment $comment){
        $data = $request->validate([
            'comment_id' => 'required',
            'post_id' => 'required',
            'reply' => 'required'
        ]);

        $data['user_id'] = Auth::user()->id;
        $newComment = comment_reply::create($data);
        return redirect(route('post.index'));
        // return redirect(route('comment_reply.index', ['comment' => $comment]))->with('success', 'Reply Added Successfully!');
    }

    public function destroy(comment_reply $comment_reply, comment $comment){
        $comment_reply->delete();
        return redirect(route('post.index'));
        // return redirect(route('comment_reply.index', ['comment' => $comment]))->with('success', 'Reply Deleted Successfully');
    }

    public function createReply(Request $request) {
        try{
            $newreply = comment_reply::create([
                'user_id' => $request->input('user_id'),
                'comment_id' => $request->input('comment_id'),
                'reply' => $request->input('reply'),
            ]);

            if($newreply){
                return response()->json([
                    'success' => true,
                    'message' => 'Reply created successfully',
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create reply. Please try again later.',
                ]);
            }

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error.',
                'error' =>  $e->getMessage()
            ]);
        }
    }

    public function showReply(Request $request){
        $comment_id = $request->input('id');
        $user_id = comment::where('id','=',$comment_id)->value('user_id');
        $replies =  comment_reply::where('comment_id', $comment_id)->orderBy('created_at', 'desc')->get();
        $user = User::where('id', $user_id)->first();
        if($replies->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'There are no replies',
            ]);
        }

        foreach($replies as $reply){
            if($reply){
                $userReply = User::where('users.id', $reply->user_id)->first();
               $datareply[] = [
                'tag' => '@' . str_replace(' ', '', strtolower($user->username)),
                'username' => str_replace(' ', '', strtolower($userReply->username)),
                'profile_pic' => $userReply->profile_pic ? json_decode($userReply->profile_pic)[0] : '',
                'reply' => $reply->reply,
                'created_at' => $reply->created_at
               ]; 
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched all replies',
            'replies' => $datareply,
        ]);

    }
}
