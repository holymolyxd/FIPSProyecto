<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\General\CollectionHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrador');
    }

    public function getComments()
    {
        $users_comments = User::join('comments','users.id','=','comments.user_id')
            ->join('careers','users.career_id','=','careers.id')
            ->join('semesters','users.semester_id','=','semesters.id')
            ->join('posts','posts.id','=','comments.post_id')
            ->join('subjects','posts.subject_id','=','subjects.id')
            ->select('comments.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name',
                'subjects.name as subject_name','users.email','comments.created_at','comments.content')
            ->orderBy('comments.id', 'DESC')->paginate(5);
        $data = [
            'users_comments' => $users_comments
        ];
        return view('admin.comments.home', $data);
    }

    public function getCommentEdit($id)
    {
        $comment = Comment::findOrFail($id);
        $data = [
            'c' => $comment,
        ];
        return view('admin.comments.comment_edit',$data);
    }

    public function postCommentSearch(Request $request)
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
            return redirect('/admin/comments')->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            switch ($request->input('filter')):
                case '0':
                    $users_comments = User::join('comments','users.id','=','comments.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('posts','posts.id','=','comments.post_id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('comments.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name',
                            'subjects.name as subject_name','users.email','comments.created_at','comments.content')
                        ->where('posts.title', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('comments.id', 'DESC')->get();
                    break;
                case '1':
                    $users_comments = User::join('comments','users.id','=','comments.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('posts','posts.id','=','comments.post_id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('comments.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name',
                            'subjects.name as subject_name','users.email','comments.created_at','comments.content')
                        ->where('posts.details', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('comments.id', 'DESC')->get();
                    break;
                case '2':
                    $users_comments = User::join('comments','users.id','=','comments.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('posts','posts.id','=','comments.post_id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('comments.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name',
                            'subjects.name as subject_name','users.email','comments.created_at','comments.content')
                        ->where('subjects.name', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('comments.id', 'DESC')->get();
                    break;
                case '3':
                    $users_comments = User::join('comments','users.id','=','comments.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('posts','posts.id','=','comments.post_id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('comments.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name',
                            'subjects.name as subject_name','users.email','comments.created_at','comments.content')
                        ->where('careers.name', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('comments.id', 'DESC')->get();
                    break;
                case '4':
                    $users_comments = User::join('comments','users.id','=','comments.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('posts','posts.id','=','comments.post_id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('comments.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name',
                            'subjects.name as subject_name','users.email','comments.created_at','comments.content')
                        ->where('semesters.name', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('comments.id', 'DESC')->get();
                    break;
                case '5':
                    $users_comments = User::join('comments','users.id','=','comments.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('posts','posts.id','=','comments.post_id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('comments.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name',
                            'subjects.name as subject_name','users.email','comments.created_at','comments.content')
                        ->where('users.email', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('comments.id', 'DESC')->get();
                    break;
                case '6':
                    $users_comments = User::join('comments','users.id','=','comments.user_id')
                        ->join('careers','users.career_id','=','careers.id')
                        ->join('semesters','users.semester_id','=','semesters.id')
                        ->join('posts','posts.id','=','comments.post_id')
                        ->join('subjects','posts.subject_id','=','subjects.id')
                        ->select('comments.id','posts.title','posts.details','careers.name as career_name','semesters.name as semester_name',
                            'subjects.name as subject_name','users.email','comments.created_at','comments.content')
                        ->where('comments.content', 'LIKE', '%'.$request->input('search').'%')
                        ->orderBy('comments.id', 'DESC')->get();
                    break;
            endswitch;

            $data = ['users_comments' => $users_comments];
            return view('admin.comments.search', $data);
        endif;
    }

    public function postCommentEdit($id, Request $request)
    {
        $comment = Comment::findOrFail($id);

        $rules = [
            'content' => 'required|max:50'
        ];

        $messages = [
            'content.required' => 'El contenido del comentario es requerido',
            'content.max' => 'El contenido del comentario debe contener al menos 50 palabras'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            $comment->content = $request->input('content');
            $comment->save();

            return redirect('/admin/comment/'.$comment->id.'/edit')
                ->with('message', 'Se ha actualizado el comentario')
                ->with('typealert', 'success');
        endif;
    }

    public function getCommentsAuditing($id)
    {
        $comment = CollectionHelper::paginate(Comment::findOrFail($id)->audits->load('user'),5);
        $data = [
            'history' => $comment,
        ];
        return view('admin.comments.auditing', $data);
    }
}
