<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Commune;
use App\Models\Gender;
use App\Models\Subject;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAccountEdit()
    {
        $genders = Gender::all();
        $communes = Commune::all();
        $venues = Venue::all();
        $careers = Career::all();
        $subjects = Subject::all();
        $data = [
            'genders' => $genders,
            'communes' => $communes,
            'venues' => $venues,
            'careers' => $careers,
            'subjects' => $subjects,
        ];
        return view('user.account_edit', $data);
    }

    public function postAccountPassword(Request $request)
    {
        $rules = [
            'apw' => ['required', Password::min(8)->mixedCase()->symbols()],
            'npw' => ['required', Password::min(8)->mixedCase()->symbols()],
            'cpw' => 'required|same:npw'
        ];

        $messages = [
            'apw.required' => 'La contraseña actual es requerida',
            'npw.required' => 'La nueva contraseña es requerida',
            'cpw.required' => 'La confirmacion de la contraseña es requerida',
            'cpw.same' => 'Las contraseñas no coinciden'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return back()->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            $u = User::find(Auth::id());
            if(Hash::check($request->input('apw'), $u->password)):
                $u->password = Hash::make($request->input('npw'));
                if($u->save()):
                    return back()
                        ->with('message', 'Su contraseña se actualizo con exito')
                        ->with('typealert', 'success')
                        ->withInput();
                endif;
            else:
                return back()
                    ->with('message', 'Su contraseña es erronea')
                    ->with('typealert', 'danger')
                    ->withInput();
            endif;
        endif;
    }

    public function postAccountInfo(Request $request)
    {
        $rules = [
            'phone' => 'required|max:9|min:9',
            'birthdate' => 'required|date',
            'gender' => 'required'
        ];

        $messages = [
            'phone.required' => 'El telefono es requerida',
            'phone.max' => 'El telefono debe contener maximo 9 caracteres',
            'phone.min' => 'El telefono debe contener minimo 9 caracteres',
            'birthdate.required' => 'La fecha de nacimiento es requerida',
            'gender.required' => 'El genero es requerido',
        ];

        $today = date('Y');
        $today_min = $today - 62;
        $today_max = $today - 18;

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return back()->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            if($request->input('birthdate') > date('Y-m-d')):
                return back()
                    ->with('message', 'La fecha de tu cumpleaños no puede ser mayor a la actual')
                    ->with('typealert', 'danger')
                    ->withInput();
            else:
                $u = User::find(Auth::id());
                if(date('Y', strtotime($request->input('birthdate'))) <= $today_min ||
                    date('Y', strtotime($request->input('birthdate'))) <= $today_max):
                    $u->phone = $request->input('phone');
                    $u->birthdate = $request->input('birthdate');
                    $u->gender_id = $request->input('gender');
                    if($u->save()):
                        return back()
                            ->with('message', 'Sus datos fueron agregados con exito')
                            ->with('typealert', 'success')
                            ->withInput();
                    endif;
                else:
                    return back()
                        ->with('message', 'No eres mayor a 18 años')
                        ->with('typealert', 'danger')
                        ->withInput();
                endif;
            endif;
        endif;
    }

    public function postAccountAdress(Request $request)
    {
        $rules = [
            'adress' => 'required|min:15|max:25',
            'commune' => 'required',
        ];

        $messages = [
            'adress.required' => 'La direccion es requerida',
            'adress.min' => 'La direccion debe contener minimo 15 caracteres',
            'adress.max' => 'La direccion debe contener maximo 25 caracteres',
            'commune.required' => 'La comuna es requerida'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return back()->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            $u = User::find(Auth::id());
            $u->adress = $request->input('adress');
            $u->commune_id = $request->input('commune');
            if($u->save()):
                return back()
                    ->with('message', 'Sus datos fueron agregados con exito')
                    ->with('typealert', 'success')
                    ->withInput();
            endif;
        endif;
    }

    public function postAccountVenues(Request $request)
    {
        $rules = [
            'venue' => 'required',
        ];

        $messages = [
            'venue.required' => 'La sede es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return back()->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            $u = User::find(Auth::id());
            $u->venue_id = $request->input('venue');
            if($u->save()):
                return back()
                    ->with('message', 'Sus datos fueron agregados con exito')
                    ->with('typealert', 'success')
                    ->withInput();
            endif;
        endif;
    }

    public function postAccountCareers(Request $request)
    {
        $rules = [
            'career' => 'required',
        ];

        $messages = [
            'career.required' => 'La Carrera es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return back()->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            $u = User::find(Auth::id());
            $u->career_id = $request->input('career');
            if($u->save()):
                return back()
                    ->with('message', 'Sus datos fueron agregados con exito')
                    ->with('typealert', 'success')
                    ->withInput();
            endif;
        endif;
    }

    public function postAccountSemester(Request $request)
    {
        $rules = [
            'semester' => 'required',
        ];

        $messages = [
            'semester.required' => 'El Semsetre es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return back()->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            #if (count($request->input('semester')) > 2):
            #    return back()->withErrors($validator)
            #        ->with('message', 'No puedes agregar más de 2 semestres')
            #        ->with('typealert', 'danger')
            #        ->withInput();
            #else:
                $u = User::find(Auth::id());
                #$u->semester_id = $request->input('semester');
                #$u->semesters()->sync($u->semesters);
                $u->semester_id = $request->input('semester');
                if($u->save()):
                    return back()
                        ->with('message', 'Sus datos fueron agregados con exito')
                        ->with('typealert', 'success')
                        ->withInput();
                endif;
        endif;
    }

    public function postAccountSubject(Request $request)
    {
        $rules = [
            'subject' => 'required',
        ];

        $messages = [
            'subject.required' => 'Las Asignaturas son requeridas',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return back()->withErrors($validator)
                ->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')
                ->withInput();
        else:
            if (count($request->input('subject')) < 5):
                return back()->withErrors($validator)
                    ->with('message', 'No puedes agregar menos de 5 Asignaturas')
                    ->with('typealert', 'danger')
                    ->withInput();
            elseif(count($request->input('subject')) > 7):
                return back()->withErrors($validator)
                    ->with('message', 'No puedes agregar mas de 7 Asignaturas')
                    ->with('typealert', 'danger')
                    ->withInput();
            else:
                $u = User::find(Auth::id());
                $u->subject = $request->input('subject');
               $u->subjects()->sync($u->subject);
                return back()
                    ->with('message', 'Sus datos fueron agregados con exito')
                    ->with('typealert', 'success')
                    ->withInput();
            endif;
        endif;
    }
}
