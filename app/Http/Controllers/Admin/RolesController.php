<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Helpers\General\CollectionHelper;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrador');

    }
    /*
        *   Visualización de la vista roles con registros
        *   Ordenados de forma descendente segun su estado.
    */
    public function getRoles($status)
    {
        if (auth()->user()->hasPermission('ver-listado-de-roles')):
            switch ($status)
            {
                case '1':
                    $roles = Role::orderBy('id', 'DESC')->paginate(8);
                break;
                case 'trash':
                    $roles = Role::onlyTrashed()->orderBy('id', 'DESC')->paginate(8);
                break;
                case 'all':
                    $roles = Role::withTrashed()->orderBy('id', 'DESC')->paginate(8);
                break;
            }

            $data = ['roles' => $roles];
            return view('admin.roles.home', $data);
        else:
            abort(403);
        endif;
    }

    /*
        *   Visualización de la vista de editar un rol con registro
        *   a modificar.
    */
    public function getRoleEdit($id)
    {
        if (auth()->user()->hasPermission('editar-roles')):
            $roles = Role::findOrFail($id);
            $role_permission = $roles->permissions()->paginate(6);
            $data = [
                'r' => $roles,
                'rp' => $role_permission,
            ];
            return view('admin.roles.role_edit', $data);
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de modificar un rol con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function postRolesEdit(Request $request, $id)
    {
        if (auth()->user()->hasPermission('editar-roles')):
            $rules = [
                #'name' => 'required|max:15|unique:roles|regex:/^[a-zA-Z ]{1,15}$/',
                'description' => 'required|max:50|regex:/^[a-zA-Z ]{1,50}$/'
            ];

            $messages = [
                #'name.required' => 'El nombre del rol es requerido',
                #'name.max' => 'El nombre del rol debe contener al menos 15 caracteres',
                #'name.unique' => 'No se puede ingresar un nombre ya existente',
                #'name.regex' => 'El nombre del rol solo debe contener palabras y no sobrepasar las 15 caracteres',
                'description.required' => 'La descripcion del rol es requerida',
                'description.regex' => 'La descripción del rol solo debe contener palabras y no sobrepasar las 50 caracteres',
                'description.max' => 'El descripción del rol debe contener al menos 50 palabras'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()):
                return back()->withErrors($validator)
                    ->with('message', 'Se ha producido un error')
                    ->with('typealert', 'danger')
                    ->withInput();
            else:
                $role = Role::findOrFail($id);
                #$role->name = $request->input('name');
                #$role->slug = Str::lower(str_replace(' ','-',$request->input('name')));
                $role->description = $request->input('description');
                #if($role->id == 1 || $role->id == 2 || $role->id == 3 || $role->id == 4):
                #    return redirect('/admin/role/'.$role->id.'/edit')
                #        ->with('message', 'Por motivos de seguridad no puedes modificar el Rol:'.$role->id)
                #        ->with('typealert', 'danger');
                if ($role->save()):
                    return redirect('/admin/role/'.$role->id.'/edit')
                        ->with('message', 'Se ha actualizado el Rol')
                        ->with('typealert', 'success');
                endif;
            endif;
        else:
            abort(403);
        endif;
    }

    /*
        *   Visualización de la vista de agregar un nuevo rol
    */
    public function getRoleAdd()
    {
        if (auth()->user()->hasPermission('agregar-nuevos-roles')):
            return view('admin.roles.add');
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de crear un rol con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function postRoleAdd(Request $request)
    {
        if (auth()->user()->hasPermission('agregar-nuevos-roles')):
            $rules = [
                'name' => 'required|max:15|unique:roles|regex:/^[a-zA-Z ]{1,20}$/',
                'description' => 'required|max:50|regex:/^[a-zA-Z ]{1,60}$/'
            ];

            $messages = [
                'name.required' => 'El nombre del rol es requerido',
                'name.unique' => 'No se puede ingresar un nombre ya existente',
                'name.max' => 'El nombre del rol debe contener al menos 15 caracteres',
                'name.regex' => 'El nombre del rol solo debe contener palabras y no sobrepasar las 15 caracteres',
                'description.required' => 'La descripcion del rol es requerida',
                'description.regex' => 'La descripción del rol solo debe contener palabras y no sobrepasar las 50 caracteres',
                'description.max' => 'La descripcion del rol debe contener al menos 50 palabras'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()):
                return back()->withErrors($validator)
                    ->with('message', 'Se ha producido un error')
                    ->with('typealert', 'danger')
                    ->withInput();
            else:
                $role = new Role();
                $role->name = e($request->input('name'));
                $role->slug = Str::lower(str_replace(' ','-',$request->input('name')));
                $role->description = e($request->input('description'));

                if($role->save()):
                    return redirect('/admin/roles/1')
                        ->with('message', 'Guardado con exito')
                        ->with('typealert', 'success');
                endif;
            endif;
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de buscar un rol con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function postRoleSearch(Request $request)
    {
        if (auth()->user()->hasPermission('buscar-roles')):
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
                return redirect('/admin/roles/1')->withErrors($validator)
                    ->with('message', 'Se ha producido un error')
                    ->with('typealert', 'danger')
                    ->withInput();
            else:
                switch ($request->input('filter')):
                    case '0':
                        $roles = Role::withTrashed()->where('name', 'LIKE', '%'.$request->input('search').'%')
                            ->orderBy('id','DESC')->get();
                        break;
                    case '1':
                        $roles = Role::withTrashed()->where('description', 'LIKE', '%'.$request->input('search').'%')
                            ->orderBy('id','DESC')->get();
                    break;
                endswitch;

                $data = ['roles' => $roles];
                return view('admin.roles.search', $data);
            endif;
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de eliminar un rol con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function getRoleDelete($id)
    {
        if (auth()->user()->hasPermission('eliminar-roles')):
            $role = Role::findOrFail($id);
            if ($role->id == 1 || $role->id == 2 || $role->id == 3 || $role->id == 4):
                return back()
                    ->with('message', 'No se puede modificar el Rol:'.$role->name.' por temas de seguridad')
                    ->with('typealert' , 'danger');
            elseif ($role->delete()):
                return back()
                    ->with('message', 'El Rol fue enviado a la papelera con exito')
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
    public function getRoleRestore($id)
    {
        if (auth()->user()->hasPermission('restaurar-roles')):
            $role = Role::onlyTrashed()->where('id',$id)->first();
            if($role->restore()):
                return redirect('/admin/role/'.$role->id.'/edit')
                    ->with('message', 'Este Rol se restauro satisfactoriamente')
                    ->with('typealert', 'success');
            endif;
        else:
            abort(403);
        endif;
    }

    /*
        *   Visualizacion del historial de un rol desde que se creo
        *   modifico, elimino y restauro.
    */
    public function getRoleAuditing($id)
    {
        if (auth()->user()->hasPermission('historial-de-roles')):
            $role = CollectionHelper::paginate(Role::findOrFail($id)->audits->load('user'),5);
            $data = [
              'history' => $role,
            ];
            return view('admin.roles.auditing', $data);
        else:
            abort(403);
        endif;
    }
}
