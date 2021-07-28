<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Comment;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Helpers\General\CollectionHelper;

class PostController extends Controller
{
    public function getMyPosts()
    {
        $posts = Post::orderBy('id', 'DESC')->where('user_id','=',auth()->id())->paginate(10);
        $data = [
          'posts' => $posts
        ];
        return view('posts.user_posts.home', $data);
    }

    public function getPostAdd(Request $request)
    {
        return view('posts.user_posts.add');
    }

    public function postPostAdd(Request $request)
    {
        $rules = [
            'title' => 'required|max:20',
            'detail' => 'required|max:50',
            'subject' => 'required'
        ];

        $messages = [
            'title.required' => 'El titulo de la publicacion es requerido',
            'title.max' => 'El titulo debe contener al menos 20 caracteres',
            'detail.required' => 'El contenido de la publicacion es requerido',
            'detail.max' => 'El contenido de la publicacion debe contener al menos 50 caracteres',
            'subject.required' => 'La asignatura es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return back()->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            $post = new Post();
            $post->title = e($request->input('title'));
            $post->slug = Str::lower(str_replace(' ','-',$request->input('title')));
            $post->details = e($request->input('detail'));
            $post->user_id = auth()->id();
            $post->subject_id = e($request->input('subject'));

            if($post->save()):
                return redirect('/')
                    ->with('message', 'Guardado con exito')
                    ->with('typealert', 'success');
            endif;
        endif;
    }

    public function postPostSearch(Request $request)
    {
        $rules = [
            'search' => 'required|regex:/^[a-zA-Z ]{1,15}$/',
            'filter' => 'required'
        ];

        $messages = [
            'search.required' => 'El campo buscar es requerido',
            'search.regex' => 'El campo buscar solo debe contener palabras y no sobrepasar las 15 caracteres',
            'filter.required' => 'El select es requerido'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return redirect('/posts')->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            switch ($request->input('filter')):
                case '0':
                    $posts = Post::where('title', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('id','DESC')->get();
                    break;
                case '1':
                    $posts = Post::where('details', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('id','DESC')->get();
                    break;
                case '2':
                    $posts = Post::join('subjects','posts.subject_id','=','subjects.id')
                        ->where('subjects.name','LIKE', '%'.$request->input('search').'%')
                        ->orderBy('posts.id','DESC')->get();
                    break;
            endswitch;

            $data = ['posts' => $posts];
            return view('posts.user_posts.search', $data);
        endif;
    }

    public function getPost($id,$slug)
    {
        $post = Post::where('slug','=',$slug)->findOrFail($id);
        if(auth()->user()->career_id == $post->user->career_id || auth()->user()->hasRole("administrador") || auth()->user()->hasRole("coordinador") || auth()->user()->hasRole("docente")):
            $data = [
                'post' => $post
            ];
            return view('posts.home_posts.product_single', $data);
        else:
            abort(403);
        endif;
    }

    public function postCommentPost($id, $slug, Request $request)
    {
        $post = Post::where('slug','=',$slug)->findOrFail($id);
        $rules = [
            'answer' => 'required|max:40|min:15',
        ];

        $messages = [
            'answer.required' => 'El comentario es requerido',
            'answer.max' => 'El comentario debe contener maximo 40 caracteres',
            'answer.min' => 'El comentario debe contener minimo 15 caracteres'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return redirect('/post/'.$post->id.'/'.$post->slug)->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            $comment = new Comment();
            $comment->content = $request->input('answer');
            $comment->user_id = auth()->id();
            $comment->post_id = $post->id;
            if($comment->save()):
                return redirect('/post/'.$post->id.'/'.$post->slug)
                    ->with('message', 'Guardado con exito')
                    ->with('typealert', 'success');
            endif;
        endif;
    }

    public function FinishPost($id,$slug,$id_comment)
    {
        $post = Post::where('slug','=',$slug)->findOrFail($id);
        $post->status = 1;
        $post->save();

        $comment = Comment::findOrFail($id_comment);
        $comment->status = 1;
        $comment->save();

        return redirect('/post/'.$post->id.'/'.$post->slug)
            ->with('message', 'La publicacion fue cerrada con exito')
            ->with('typealert', 'success');
    }

    public function  getUsersPosts($id,$email)
    {
        $user = User::where('email','=',$email)->findOrFail($id);
        $posts = CollectionHelper::paginate($user->posts,5);
        $data = [
            'user' => $user,
            'posts' => $posts
        ];
        return view('posts.home_posts.users_all_posts', $data);
    }

    public function postUsersPostsSearch($id,$email, Request $request)
    {
        $user = User::where('email','=',$email)->findOrFail($id);
        $rules = [
            'search' => 'required|regex:/^[a-zA-Z ]{1,25}$/',
            'filter' => 'required'
        ];

        $messages = [
            'search.required' => 'El campo buscar es requerido',
            'search.regex' => 'El campo buscar solo debe contener palabras y no sobrepasar las 15 caracteres',
            'filter.required' => 'El select es requerido'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return redirect('/user/'.$user->id.'/'.$user->email.'/posts')->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            switch ($request->input('filter')):
                case '0':
                    $posts = User::join('posts','users.id','=','posts.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->join('venues','users.venue_id','=','venues.id')
                        ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name','subjects.name as subject_name',
                            'users.name as user_name','users.email','posts.created_at','venues.name as venue_name', 'posts.status')
                        ->where('posts.title', 'LIKE', '%'.$request->input('search').'%')
                        ->where('users.id','=',$id)
                        ->orderBy('posts.id', 'DESC')->get();
                    break;
                case '1':
                    $posts = User::join('posts','users.id','=','posts.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->join('venues','users.venue_id','=','venues.id')
                        ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name','subjects.name as subject_name',
                            'users.name as user_name','users.email','posts.created_at','venues.name as venue_name', 'posts.status')
                        ->where('posts.details', 'LIKE', '%'.$request->input('search').'%')
                        ->where('users.id','=',$id)
                        ->orderBy('posts.id', 'DESC')->get();
                    break;
                case '2':
                    $posts = User::join('posts','users.id','=','posts.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->join('venues','users.venue_id','=','venues.id')
                        ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name','subjects.name as subject_name',
                            'users.name as user_name','users.email','posts.created_at','venues.name as venue_name', 'posts.status')
                        ->where('subjects.name', 'LIKE', '%'.$request->input('search').'%')
                        ->where('users.id','=',$id)
                        ->orderBy('posts.id', 'DESC')->get();
                    break;
            endswitch;

            $data = ['posts' => $posts];
            return view('posts.home_posts.users_search_posts', $data);
        endif;
    }

    public function getCareersPosts($id,$slug)
    {
        $career = Career::where('slug','=',$slug)->findOrFail($id);
        $career_user = $career->users;
        $posts = CollectionHelper::paginate(Post::join('subjects','subjects.id','=','posts.subject_id')
            ->join('careers_subjects','careers_subjects.subject_id','=','subjects.id')
            ->join('careers','careers.id','=','careers_subjects.career_id')
            ->join('users','users.id','=','posts.user_id')
            ->select('posts.id', 'posts.title', 'posts.details', 'posts.slug', 'posts.created_at','users.email',
                'subjects.name as subject_name','careers.name as career_name', 'posts.status')
            ->where('careers.id',$id)->get(),5);
        $data = [
            'career' => $career,
            'users' => $career_user,
            'posts' => $posts
        ];
        return view('posts.home_posts.careers_all_posts', $data);
    }

    public function postCareersPostsSearch($id,$slug, Request $request)
    {
        $career = Career::where('slug','=',$slug)->findOrFail($id);
        $rules = [
            'search' => 'required|regex:/^[a-zA-Z ]{1,25}$/',
            'filter' => 'required'
        ];

        $messages = [
            'search.required' => 'El campo buscar es requerido',
            'search.regex' => 'El campo buscar solo debe contener palabras y no sobrepasar las 15 caracteres',
            'filter.required' => 'El select es requerido'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return redirect('/careers/'.$career->id.'/'.$career->slug.'/posts')->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            switch ($request->input('filter')):
                case '0':
                    if(auth()->user()->hasRole("administrador") || auth()->user()->hasRole("profesor")):
                    $posts = Career::join('users','users.career_id','=','careers.id')
                        ->join('posts','posts.user_id','=','users.id')
                        ->join('subjects','subjects.id','=','posts.subject_id')
                        ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                        'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                        ->where('posts.title', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('posts.id','DESC')->get();
                    else:
                        $posts = Career::join('users','users.career_id','=','careers.id')
                            ->join('posts','posts.user_id','=','users.id')
                            ->join('subjects','subjects.id','=','posts.subject_id')
                            ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                                'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                            ->where('posts.title', 'LIKE', '%'.$request->input('search').'%')
                            ->where('careers.id','=',$id)
                            ->orderBy('posts.id','DESC')->get();
                    endif;
                    break;
                case '1':
                    if(auth()->user()->hasRole("administrador") || auth()->user()->hasRole("profesor")):
                    $posts= Career::join('users','users.career_id','=','careers.id')
                        ->join('posts','posts.user_id','=','users.id')
                        ->join('subjects','subjects.id','=','posts.subject_id')
                        ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                            'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                        ->where('posts.details', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('posts.id','DESC')->get();
                    else:
                        $posts= Career::join('users','users.career_id','=','careers.id')
                            ->join('posts','posts.user_id','=','users.id')
                            ->join('subjects','subjects.id','=','posts.subject_id')
                            ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                                'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                            ->where('posts.details', 'LIKE', '%'.$request->input('search').'%')
                            ->where('careers.id','=',$id)
                            ->orderBy('posts.id','DESC')->get();
                    endif;
                    break;
                case '2':
                    if(auth()->user()->hasRole("administrador") || auth()->user()->hasRole("profesor")):
                    $posts= Career::join('users','users.career_id','=','careers.id')
                        ->join('posts','posts.user_id','=','users.id')
                        ->join('subjects','subjects.id','=','posts.subject_id')
                        ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                            'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                        ->where('subjects.name', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('posts.id','DESC')->get();
                    else:
                        $posts= Career::join('users','users.career_id','=','careers.id')
                            ->join('posts','posts.user_id','=','users.id')
                            ->join('subjects','subjects.id','=','posts.subject_id')
                            ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                                'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                            ->where('subjects.name', 'LIKE', '%'.$request->input('search').'%')
                            ->where('careers.id','=',$id)
                            ->orderBy('posts.id','DESC')->get();
                    endif;
                    break;
            endswitch;

            $data = ['posts' => $posts, 'career' => $career];
            return view('posts.home_posts.careers_search_posts', $data);
        endif;
    }
    public function getSubjectsPosts($id, $slug)
    {
        $subject = Subject::where('slug','=',$slug)->findOrFail($id);

        if(auth()->user()->hasRole("administrador") || auth()->user()->hasRole("profesor")):
            $posts = CollectionHelper::paginate(Post::join('subjects','subjects.id','=','posts.subject_id')
                ->join('careers_subjects','careers_subjects.subject_id','=','subjects.id')
                ->join('careers','careers.id','=','careers_subjects.career_id')
                ->join('users','users.id','=','posts.user_id')
                ->select('posts.id', 'posts.title', 'posts.details', 'posts.slug', 'posts.created_at','users.email',
                    'subjects.name as subject_name','careers.name as career_name', 'posts.status')
                ->where('subjects.id',$id)->get(),5);
        else:
            $posts = CollectionHelper::paginate(Post::join('subjects','subjects.id','=','posts.subject_id')
                ->join('careers_subjects','careers_subjects.subject_id','=','subjects.id')
                ->join('careers','careers.id','=','careers_subjects.career_id')
                ->join('users','users.id','=','posts.user_id')
                ->select('posts.id', 'posts.title', 'posts.details', 'posts.slug', 'posts.created_at','users.email',
                    'subjects.name as subject_name','careers.name as career_name', 'posts.status')
                ->where('careers.id','=',auth()->user()->career_id)
                ->where('subjects.id',$id)->get(),5);
        endif;
        $data = [
            'subject' => $subject,
            'posts' => $posts
        ];
        return view('posts.home_posts.subjects_all_posts', $data);
    }

    public function postSubjectsPostsSearch($id,$slug, Request $request)
    {
        $subject = Subject::where('slug','=',$slug)->findOrFail($id);

        $rules = [
            'search' => 'required|regex:/^[a-zA-Z ]{1,25}$/',
            'filter' => 'required'
        ];

        $messages = [
            'search.required' => 'El campo buscar es requerido',
            'search.regex' => 'El campo buscar solo debe contener palabras y no sobrepasar las 15 caracteres',
            'filter.required' => 'El select es requerido'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return redirect('/subjects/'.$subject->id.'/'.$subject->slug.'/posts')->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            switch ($request->input('filter')):
                case '0':
                    if(auth()->user()->hasRole("administrador") || auth()->user()->hasRole("profesor")):
                    $posts = Subject::join('posts','posts.subject_id','=','subjects.id')
                        ->join('users','users.id','=','posts.user_id')
                        ->join('careers','careers.id','=','users.career_id')
                        ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                            'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                        ->where('posts.title', 'LIKE', '%'.$request->input('search').'%')
                        ->where('posts.subject_id','=',$id)
                        ->orderBy('posts.id','DESC')->get();
                    else:
                        $posts = Subject::join('posts','posts.subject_id','=','subjects.id')
                            ->join('users','users.id','=','posts.user_id')
                            ->join('careers','careers.id','=','users.career_id')
                            ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                                'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                            ->where('posts.title', 'LIKE', '%'.$request->input('search').'%')
                            ->where('careers.id','=',auth()->user()->career_id)
                            ->where('posts.subject_id','=',$id)
                            ->orderBy('posts.id','DESC')->get();
                    endif;
                    break;
                case '1':
                    if(auth()->user()->hasRole("administrador") || auth()->user()->hasRole("profesor")):
                        $posts= Subject::join('posts','posts.subject_id','=','subjects.id')
                            ->join('users','users.id','=','posts.user_id')
                            ->join('careers','careers.id','=','users.career_id')
                            ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                                'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                            ->where('posts.details', 'LIKE', '%'.$request->input('search').'%')
                            ->where('posts.subject_id','=',$id)
                            ->orderBy('posts.id','DESC')->get();
                    else:
                        $posts= Subject::join('posts','posts.subject_id','=','subjects.id')
                            ->join('users','users.id','=','posts.user_id')
                            ->join('careers','careers.id','=','users.career_id')
                            ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                                'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                            ->where('posts.details', 'LIKE', '%'.$request->input('search').'%')
                            ->where('careers.id','=',auth()->user()->career_id)
                            ->where('posts.subject_id','=',$id)
                            ->orderBy('posts.id','DESC')->get();
                    endif;
                    break;
                case '2':
                    if(auth()->user()->hasRole("administrador") || auth()->user()->hasRole("profesor")):
                        $posts= Subject::join('posts','posts.subject_id','=','subjects.id')
                            ->join('users','users.id','=','posts.user_id')
                            ->join('careers','careers.id','=','users.career_id')
                            ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                                'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                            ->where('careers.name', 'LIKE', '%'.$request->input('search').'%')
                            ->where('posts.subject_id','=',$id)
                            ->orderBy('posts.id','DESC')->get();
                    else:
                        $posts= Subject::join('posts','posts.subject_id','=','subjects.id')
                            ->join('users','users.id','=','posts.user_id')
                            ->join('careers','careers.id','=','users.career_id')
                            ->select('posts.id','posts.slug','posts.title','posts.details','careers.name as career_name',
                                'subjects.name as subject_name','users.email','posts.created_at', 'posts.status')
                            ->where('careers.name', 'LIKE', '%'.$request->input('search').'%')
                            ->where('careers.id','=',auth()->user()->career_id)
                            ->where('posts.subject_id','=',$id)
                            ->orderBy('posts.id','DESC')->get();
                    endif;
                    break;
            endswitch;

            $data = [
                'subject' => $subject,
                'posts' => $posts
            ];
            return view('posts.home_posts.subjects_search_posts', $data);
        endif;
    }
}
