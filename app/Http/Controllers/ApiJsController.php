<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class ApiJsController extends Controller
{
    public function getPostSection($section)
    {
        switch ($section):
            case 'home':
                if(auth()->user()->hasRole("estudiante")):
                $posts = DB::table('posts')
                    ->join('users', 'users.id','=','posts.user_id')
                    ->join('careers', 'careers.id','=','users.career_id')
                    ->join('subjects', 'subjects.id','=','posts.subject_id')
                    ->where('users.career_id','=',auth()->user()->career_id)
                    ->select('posts.id as post_id','posts.title','posts.slug','posts.details','users.email','careers.name as career_name', 'subjects.name as subject_name', 'posts.created_at as post_created_at', 'posts.status')
                    ->paginate(10);

                else:
                    $posts = DB::table('posts')
                        ->join('users', 'users.id','=','posts.user_id')
                        ->join('careers', 'careers.id','=','users.career_id')
                        ->join('subjects', 'subjects.id','=','posts.subject_id')
                        ->select('posts.id as post_id','posts.title','posts.slug','posts.details','users.email','careers.name as career_name', 'subjects.name as subject_name', 'posts.created_at as post_created_at', 'posts.status')
                        ->paginate(10);

                endif;
            break;
         endswitch;

         return $posts;
    }
}
