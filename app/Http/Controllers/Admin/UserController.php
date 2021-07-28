<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\General\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\RoleUser;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrador');
    }

    /*
        *   Visualización de la vista usuarios con registros
        *   Ordenados de forma descendente.
    */
    public function getUsers($status)
    {
        if (auth()->user()->hasPermission('ver-listado-de-usuarios')):
            switch ($status)
            {
                case '1':
                    $users = User::orderBy('id', 'DESC')->paginate(8);
                    break;
                case 'trash':
                    $users = User::onlyTrashed()->orderBy('id', 'DESC')->paginate(8);
                    break;
                case 'all':
                    $users = User::withTrashed()->orderBy('id', 'DESC')->paginate(8);
                    break;
            }
            $data = ['users' => $users];
            return view('admin.users.home', $data);
        else:
            abort(403);
        endif;
    }

    /*
        *   Visualización de la vista de editar usuario con registro
        *   a modificar y el listado de roles completo.
    */
    public function getUserEdit($id)
    {
        if (auth()->user()->hasPermission('editar-roles-de-usuarios')):
            $roles = Role::all();
            $user = User::findOrFail($id);
            $permissions = Permission::all();
            $user_permission = $user->permissions()->paginate(3);
            $data = [
                'u' => $user,
                'r' => $roles,
                'p' => $permissions,
                'up' => $user_permission,
            ];
            return view('admin.users.user_edit', $data);
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de modificar un usuario con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function postUsersEdit(Request $request, $id)
    {
        if (auth()->user()->hasPermission('editar-roles-de-usuarios')):
            $user = User::findOrFail($id);
            $user->role = $request->input('rol');
            $user->permission = $request->input('permission');

            $rules = [
                'rol' => 'required',
            #    'permission' => 'required'
            ];

            $messages = [
                'rol.required' => 'El tipo de usuario es requerido',
            #    'permission.required' => 'El/los permisos de usuario es requerido'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()):
                return back()->withErrors($validator)
                    ->with('message', 'Se ha producido un error')
                    ->with('typealert', 'danger')
                    ->withInput();
                else:
                    $user->roles()->sync($user->role);
                    #$user->permissions()->sync($user->permission);

                    return redirect('/admin/user/'.$user->id.'/permissions')
                        ->with('message', 'Se ha actualizado el tipo de usuario para '.$user->name. ' (ID:'.$user->id.')')
                        ->with('typealert', 'success');
            endif;
        else:
            abort(403);
        endif;
    }

    public function getUserAdd()
    {
        if (auth()->user()->hasPermission('agregar-nuevos-usuarios')):
            return view('admin.users.add');
        else:
            abort(403);
        endif;
    }

    public function postUserAdd(Request $request)
    {
        if (auth()->user()->hasPermission('agregar-nuevos-usuarios')):
            $rules = [
                'rut'   => 'required|unique:users|max:9|cl_rut',
                'username' => 'required|max:15',
                'email' => 'required|email|max:40|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([inacapmail]+\.)+[cl]{2,6}$/ix',
                'password' => ['required', Password::min(8)->mixedCase()->symbols()],
                'cpassword' => 'required|same:password'
            ];

            $messages = [
                'rut.required' => 'El RUT del usuario es requerido',
                'rut.unique' => 'El RUT es unico',
                'rut.max' => 'El RUT del usuario debe contener como maximo 12 caracteres',
                #'rut.cl_rut' => 'El RUT ingresado no es valido ,el DV es: '.Rut::set($request->input('rut'))->calculateVerificationNumber(),
                'rut.cl_rut' => 'El RUT ingresado no es valido',
                'username.required' => 'El username es requerido',
                'username.max' => 'El username debe contener como maximo 15 caracteres',
                'email.required' => 'El email es requerido',
                'email.email' => 'El formato del correo electronico es incorrecto',
                'email.max' => 'El correo electronico debe contener como maximo 40 caracteres',
                'email.regex' => 'El correo electronico no cumple con los estandares de INACAP',
                'email.unique' => 'No se puede ingresar un correo electronico ya existente',
                'password.required' => 'La contraseña es requerida',
                'password.regex' => 'La contraseña debe tener al menos una mayuscula, una minuscula y un simbolo',
                'cpassword.required' => 'La confirmacion de la contraseña es requerida',
                'cpassword.same' => 'Las contraseñas no coinciden'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()):
                return back()->withErrors($validator)
                    ->with('message', 'Se ha producido un error')
                    ->with('typealert', 'danger')
                    ->withInput();
            else:
                $user = new User();
                $user->rut = $request->input('rut');
                $user->name = $request->input('username');
                $user->email = $request->input('email');
                $user->password = bcrypt($request->input('password'));

                if($user->save()):
                    return redirect('/admin/users/1')
                        ->with('message', 'Guardado con exito')
                        ->with('typealert', 'success');
                endif;
            endif;
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de buscar un usuario con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function postUserSearch(Request $request)
    {
        if (auth()->user()->hasPermission('buscar-usuarios')):
            $rules = [
                'search' => 'required|max:15',
                'filter' => 'required'
            ];

            $messages = [
                'search.required' => 'El campo buscar es requerido',
                'search.max' => 'El campo buscar no debe sobrepasar las 15 caracteres',
                'filter.required' => 'El select es requerido'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()):
                return redirect('/admin/users/1')->withErrors($validator)
                    ->with('message', 'Se ha producido un error')
                    ->with('typealert', 'danger')
                    ->withInput();
            else:
                switch ($request->input('filter')):
                    case '0':
                        $users = User::withTrashed()->where('rut', 'LIKE', '%'.$request->input('search').'%')
                            ->orderBy('id','DESC')->get();
                        break;
                    case '1':
                        $users = User::withTrashed()->where('name', 'LIKE', '%'.$request->input('search').'%')
                            ->orderBy('id','DESC')->get();
                        break;
                    case '2':
                        $users = User::withTrashed()->where('email', 'LIKE', '%'.$request->input('search').'%')
                            ->orderBy('id','DESC')->get();
                        break;
                endswitch;

                $data = ['users' => $users];
                return view('admin.users.search', $data);
            endif;
        else:
            abort(403);
        endif;

    }

    /*
        *   Visualización de la vista de permisos de usuario con registro
        *   a modificar y el listado de permisos por roles y modulos.
    */
    public function getUsersPermissions($id)
    {
        if (auth()->user()->hasPermission('editar-permisos-de-usuarios')):
            $user = User::find($id);
            $roles = Role::pluck('name','name')->all();
            $userRole = $user->roles->pluck('id','id')->all();
            foreach ($userRole as $role){
                $rol = Role::where('id',$role)->first();
                $dashboard = $rol->permissions->where('module','dashboard');
                $slider = $rol->permissions->where('module','slider');
                $role = $rol->permissions->where('module','roles');
                $permisos = $rol->permissions->where('module','permisos');
                $usuarios = $rol->permissions->where('module','usuarios');
                #dd($permission);
            }
            #dd($userRole);
            $data = [
                'user' => $user,
                'dashboard' => $dashboard,
                'slider' => $slider,
                'role' => $role,
                'permisos' => $permisos,
                'usuarios' => $usuarios,
                ];
            return view('admin.users.user_permissions', $data);
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de modificar el/los permisos de un usuario
        * con las reglas a aplicar, los mensajes correspondientes
        * para realizar la accion.
    */
    public function postUsersPermissions(Request $request, $id)
    {
        if (auth()->user()->hasPermission('editar-permisos-de-usuarios')):
            $user = User::findOrFail($id);
            $permission = [
                'ver-listado-de-roles' => $request->input('ver-listado-de-roles'),
                'agregar-nuevos-roles' => $request->input('agregar-nuevos-roles'),
                'editar-roles' => $request->input('editar-roles'),
                'buscar-roles' => $request->input('buscar-roles'),
                'eliminar-roles' => $request->input('eliminar-roles'),
                'restaurar-roles' => $request->input('restaurar-roles'),
                'historial-de-roles' => $request->input('historial-de-roles'),
                'ver-listado-de-permisos' => $request->input('ver-listado-de-permisos'),
                'agregar-nuevos-permisos' => $request->input('agregar-nuevos-permisos'),
                'editar-permisos' => $request->input('editar-permisos'),
                'buscar-permisos' => $request->input('buscar-permisos'),
                'eliminar-permisos' => $request->input('eliminar-permisos'),
                'restaurar-permisos' => $request->input('restaurar-permisos'),
                'historial-de-permisos' => $request->input('historial-de-permisos'),
                'ver-dashboard' => $request->input('ver-dashboard'),
                'ver-estadisticas-rapidas' => $request->input('ver-estadisticas-rapidas'),
                'ver-graficas' => $request->input('ver-graficas'),
                'ver-slider' => $request->input('ver-slider'),
                'ver-listado-de-usuarios' => $request->input('ver-listado-de-usuarios'),
                'agregar-nuevos-usuarios' => $request->input('agregar-nuevos-usuarios'),
                'editar-roles-de-usuarios' => $request->input('editar-roles-de-usuarios'),
                'editar-permisos-de-usuarios' => $request->input('editar-permisos-de-usuarios'),
                'buscar-usuarios' => $request->input('buscar-usuarios'),
                'eliminar-usuarios' => $request->input('eliminar-usuarios'),
                'restaurar-usuarios' => $request->input('restaurar-usuarios'),
            ];

            $permissions = array_values(array_filter($permission));

            $user->permissions()->sync($permissions);

            return redirect('/admin/users/1')
                ->with('message', 'Se han actualizado los permisos de usuario para el Usuario:'. $user->name. ' (ID:'.$user->id.')')
                ->with('typealert', 'success');
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de eliminar un rol con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function getUserDelete($id)
    {
        if (auth()->user()->hasPermission('eliminar-usuarios')):
            $user = User::findOrFail($id);
            if ($user->delete()):
                return back()
                    ->with('message', 'El Usuario'.$user->name.' fue enviado a la papelera con exito')
                    ->with('typealert' , 'success');
            endif;
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de restaurar un rol con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function getUserRestore($id)
    {
        if (auth()->user()->hasPermission('restaurar-usuarios')):
            $user = User::onlyTrashed()->where('id',$id)->first();
            if($user->restore()):
                return redirect('/admin/user/'.$user->id.'/edit')
                    ->with('message', 'Este Usuario se restauro satisfactoriamente')
                    ->with('typealert', 'success');
            endif;
        else:
            abort(403);
        endif;
    }

    /*
    public function getUserAuditing($id)
    {
        $user = User::with('roles')->where('id','=',$id);
        dd($user);
        $data = [
            'history' => $user,
        ];
        return view('admin.users.auditing', $data);
    }
    */
}
