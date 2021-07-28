<?php

namespace App\Http\Controllers;

use App\Helpers\General\CollectionHelper;
use App\Models\Post;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getHome()
    {
        if(auth()->user()->hasRole("estudiante")):
            $posts = Post::join('users','users.id','=','posts.user_id')
                ->where('users.career_id','=', auth()->user()->career_id)
                ->select('posts.*')->OrderBy('id','DESC')->paginate(4);
        else:
            $posts =CollectionHelper::paginate(Post::all()->sortDesc(),4);
        endif;
        $data = [
            'posts' => $posts
        ];

        return view('home', $data);
    }
}
