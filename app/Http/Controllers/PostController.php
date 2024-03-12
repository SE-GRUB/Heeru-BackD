<?php

namespace App\Http\Controllers;
use App\Models\comment;
use App\Models\comment_reply;
use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $dataPosts = [];
        $posts = Post::all();
        foreach ($posts as $post) {
            $dataComments = [];
            $user = User::find($post->user_id);
    
            if ($user) {
                $comments = Comment::where('post_id', $post->id)->get();
    
                foreach ($comments as $comment) {
                    $dataReplies = [];
                    $commentUser = User::find($comment->user_id);

                    if ($commentUser) {
                        $replies = comment_reply::where('comment_id', $comment->id)->get();
                        foreach($replies as $reply){
                            $replyUser = User::find($reply->user_id);
                            if($replyUser){
                                $dataReplies[] = [
                                    'id' => $reply->id,
                                    'profile_pic' => $replyUser->profile_pic ?  json_decode($replyUser->profile_pic)[0] : '',
                                    'replier' => $replyUser->name,
                                    'reply_body' => $reply->reply,
                                ];
                            }
                        }
                        $dataComments[] = [
                            'id' => $comment->id,
                            'user' => $commentUser->name,
                            'comment' => $comment->comment,
                            'replies' => $dataReplies,
                            'profile_pic' => $commentUser->profile_pic ? json_decode($commentUser->profile_pic)[0] : '',
                        ];
                    }
                }
    
                $dataPosts[] = [
                    'id' => $post->id,
                    'name' => $user->isAnonymous ? 'Anonymous' : $user->name,
                    'profile_pic' => $user->profile_pic ? json_decode($user->profile_pic)[0] : '',
                    'post_body' => $post->post_body,
                    'poster' => $post->poster ? json_decode($post->poster)[0] : '',
                    'like' => $post->like,
                    'created_at' => $post->created_at,
                    'comments' => $dataComments,
                ];
            }
        }
        return view('post.index', ['posts' => $dataPosts]);
    }

    public function create(){
        $users = User::all();
        return view('post.create', ['users' => $users]);
    }

    public function createPost(Request $request){
        $data = $request->validate([
            'user_id' => 'required',
            'post_body'=> 'required',
        ]);

        try {
            $newPost = post::create([
                'user_id' => $data['user_id'],
                'post_body' => $data['post_body'],
            ]);

            $files = $request->file('poster');
            $path = 'post_poster/' . $newPost->id;
            $paths = $this->uploadedFiles($files, $path);

            $postPath = json_encode($paths);

            $newPost->update(['post' => $postPath]);

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => [
                    'post' => $newPost,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create post. Please try again later.',
            ]);
        }
    }

    public function store(Request $request){
        // dd($request);
        $data = $request->validate([
            'user_id' => 'required',
            'post_body' => 'required',
        ]);
        $data['like'] = 0;
        $data['isVerified'] = false;
        $data['isAnonymous'] = $request->input('isAnonymous', false);
        $newPost = post::create($data);
        return redirect((route(('post.index'))))->with('success', 'Post Added Successfully !');;
    }


    public function edit(post $post){
        $users = User::all();
        return view('post.edit', ['post' => $post], ['users' => $users]);
    }

    public function update(post $post, Request $request){
        $data = $request->validate([
            'user_id' => 'required',
            'post_body' => 'required',
        ]);
        $data['isAnonymous'] = $request->input('isAnonymous', false);
        $post->update(($data));
        return redirect(route('post.index'))->with('success', 'Post Updated Successfully');
    }

    public function destroy(post $post){
        $comment_replies = comment_reply::where('post_id', $post->id)->get();
        foreach($comment_replies as $comment_reply){
            $comment_reply->delete();
        }
        $comments = comment::where('post_id', $post->id)->get();
        foreach($comments as $comment){
            $comment->delete();
        }
        $post->delete();
        return redirect(route('post.index'))->with('success', 'Post Deleted Successfully');
    }

    public function showPost(Request $request){
        $page = $request->query('page', 1);
        $posts = Post::orderBy('created_at', 'desc')->paginate(10, ['*'], 'page', $page);
        $dataPosts = [];

        foreach ($posts as $post) {
            $dataPosts[] = $this->formatPost($post);
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched all posts',
            'posts' => $dataPosts,
        ]);
    }

    protected function formatPost($post){
        $dataComments = [];
        $user = User::where('id', $post->user_id)->first();

        if ($user) {
            $comments = Comment::where('post_id', $post->id)->get();

            if ($comments) {
                foreach ($comments as $comment) {
                    $dataComments[] = $this->formatComment($comment);
                }
            }

            return [
                'post_id' => $post->id,
                'name' => $user->isAnonymous ? 'Anonymous' : $user->name,
                'profile_pic' => $user->profile_pic ? json_decode($user->profile_pic)[0] : '',
                'post_body' => $post->post_body,
                'poster' => $post->poster ? json_decode($post->poster)[0] : '',
                'like' => $post->like,
                'created_at' => $post->created_at,
                'totalcomments' => count($dataComments),
                'comments' => $dataComments,
            ];
        }

        return null;
    }

    protected function formatComment($comment){
        $user = User::where('id', $comment->user_id)->first();

        if ($user) {
            return [
                'user' => $user->name,
                'comment' => $comment->comment,
                'profilkomen' => $user->profile_pic ? json_decode($user->profile_pic)[0] : '',
            ];
        }

        return null;
    }                                                                       
}