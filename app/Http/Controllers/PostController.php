<?php

    namespace App\Http\Controllers;
    use App\Models\comment;
    use App\Models\comment_reply;
use App\Models\like;
use App\Models\post;
    use App\Models\User;
    use Illuminate\Http\Request;

    class PostController extends Controller
    {
        //singgel create
        public function poincreate(Request $request){
            $data = $request->validate([
                'user_id' => 'required',
            ]);
            $data = User::where('id', $data['user_id'])->first();
            return view('ManualVenlib.post', ['data' => $data]);
        }

        // file and img link
        // Function to handle uploaded files and return their paths
        public function uploadedFiles($files, $path)
        {
            $file=$files;
            $paths = [];


            // foreach ($files as $file) {
            // dd($file,'aa');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // dd($fileName, $file->getClientOriginal/Name());
            $file->move(public_path($path), $fileName);
            if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
                // For image files
                $paths[] = '<img src="' . asset($path . '/' . $fileName) . '" alt="image" class="img-fluid">';
            } else {
                // For other file types
                $paths[] = '<a href="' . asset($path . '/' . $fileName) . '" download>' . $file->getClientOriginalName() . '</a>';
            }
            // }
            // dd($paths);
            return $paths;
        }

        private function uploadedfile0($img, $path) {
            $time=time();
            $newurl=[];
            // dd($img);
            $imag=$img;
            if ($imag->isValid()) {
                $imag->move($path, $time . '_' . $imag->getClientOriginalName());
                $newurl[] = $path . '/' . $time . '_' . $imag->getClientOriginalName();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload file',
                    'error' => 'File upload failed',
                ]);
            }
            return $newurl;
        }

        public function uplodnewpost(Request $request){
            // dump($request);
            $data['like'] = 0;
            $data['isVerified'] = false;
            $data['isAnonymous'] = $request->input('isAnonymous', false);
            $data['user_id'] = $request->input('user_id');
            $data['post_body'] = $request->input('isipost');
            $data['poster'] = null;
            foreach ($request->file() as $files) {
                if ($files) {
                    $path = 'post_poster/' . $data['user_id'];
                    $paths = $this->uploadedfile0($files, $path);
                    $data['poster'] = json_encode($paths);
                }

            }
            $newPost = Post::create($data);

            return view('ManualVenlib.postSuccess', ['newPost' => $newPost]);
        }

        //save data
        public function poinstore(Request $request){
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
                    'like' => 0,
                    'isVerified' => false,
                    'isAnonymous' => $request->input('isAnonymous', false),
                ]);

                if($request['poster']){
                    $files = $request->file('poster');
                    $path = 'post_poster/' . $newPost->id;
                    $paths = $this->uploadedfile0($files, $path);
                    $postPath = json_encode($paths);
                    $newPost->update(['poster' => $postPath]);
                }

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
            $user_id = $request->input('user_id');
            $posts = Post::orderBy('created_at', 'desc')->paginate(10, ['*'], 'page', $page);
            $dataPosts = [];

            foreach ($posts as $post) {
                $dataPosts[] = $this->formatPost($post, $user_id);
            }

            return response()->json([
                'success' => true,
                'message' => 'Fetched all posts',
                'posts' => $dataPosts,
            ]);
        }

        protected function formatPost($post, $user_id){
            $dataComments = [];
            $user = User::where('id', $post->user_id)->first();

            $likeCount = like::where('post_id', $post->id)->count();
            $liked = Like::where('user_id', $user_id)
             ->where('post_id', $post->id)
             ->exists();

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
                    'isLiked' => $liked,
                    'like' => $likeCount,
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
