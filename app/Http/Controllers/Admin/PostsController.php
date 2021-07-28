<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\General\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrador');
    }

    public function getPosts()
    {
        $users_posts = User::join('posts','users.id','=','posts.user_id')
            ->join('careers','users.career_id','=','careers.id')
            ->join('semesters','users.semester_id','=','semesters.id')
            ->join('subjects','posts.subject_id','=','subjects.id')
            ->select('posts.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name','subjects.name as subject_name','users.email','posts.created_at')
            ->orderBy('posts.id', 'DESC')->paginate(5);
        $data = [
            'users_posts' => $users_posts
        ];
        return view('admin.posts.home', $data);
    }

    public function postPostSearch(Request $request)
    {
        $rules = [
            'search' => 'required|regex:/^[a-zA-Zñ-Ñ ]{1,15}$/',
            'filter' => 'required'
        ];

        $messages = [
            'search.required' => 'El campo buscar es requerido',
            'search.regex' => 'El campo buscar solo debe contener palabras y no sobrepasar las 15 caracteres',
            'filter.required' => 'El select es requerido'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return redirect('/admin/posts')->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            switch ($request->input('filter')):
                case '0':
                    $users_posts = User::join('posts','users.id','=','posts.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('posts.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name','subjects.name as subject_name','users.email','posts.created_at')
                        ->where('posts.title', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('posts.id', 'DESC')->get();
                    break;
                case '1':
                    $users_posts = User::join('posts','users.id','=','posts.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('posts.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name','subjects.name as subject_name','users.email','posts.created_at')
                        ->where('posts.details', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('posts.id', 'DESC')->get();
                        break;
                case '2':
                    $users_posts = User::join('posts','users.id','=','posts.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('posts.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name','subjects.name as subject_name','users.email','posts.created_at')
                        ->where('subjects.name', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('posts.id', 'DESC')->get();
                    break;
                case '3':
                    $users_posts = User::join('posts','users.id','=','posts.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('posts.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name','subjects.name as subject_name','users.email','posts.created_at')
                        ->where('careers.name', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('posts.id', 'DESC')->get();
                    break;
                case '4':
                    $users_posts = User::join('posts','users.id','=','posts.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('posts.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name','subjects.name as subject_name','users.email','posts.created_at')
                        ->where('semesters.name', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('posts.id', 'DESC')->get();
                    break;
                case '5':
                    $users_posts = User::join('posts','users.id','=','posts.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('posts.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name','subjects.name as subject_name','users.email','posts.created_at')
                        ->where('users.email', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('posts.id', 'DESC')->get();
                    break;
            endswitch;

            $data = ['users_posts' => $users_posts];
            return view('admin.posts.search', $data);
        endif;
    }

    public function getPostEdit($id)
    {
        $post = Post::findOrFail($id);
        $data = [
            'p' => $post,
        ];
        return view('admin.posts.post_edit',$data);
    }

    public function postPostEdit($id, Request $request)
    {
        $post = Post::findOrFail($id);

        $rules = [
            'title' => 'required|max:20',
            'details' => 'required|max:50'
        ];

        $messages = [
            'title.required' => 'El titulo del a publicacion es requerido',
            'title.max' => 'El titulo de la publicacion debe contener al menos 20 caracteres',
            'details.required' => 'El contenido de la publicacion es requerida',
            'details.max' => 'El contenido de la publicacion debe contener al menos 50 palabras'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
                $post->title = $request->input('title');
                $post->details = $request->input('details');
                $post->save();

                return redirect('/admin/post/'.$post->id.'/edit')
                    ->with('message', 'Se ha actualizado la publicacion')
                    ->with('typealert', 'success');
        endif;
    }

    public function getPostsAuditing($id)
    {
        $post = CollectionHelper::paginate(Post::findOrFail($id)->audits->load('user'),5);
        $data = [
            'history' => $post,
        ];
        return view('admin.posts.auditing', $data);
    }
}
