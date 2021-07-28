<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\General\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrador');
    }

    /*
        *   Visualización de la vista permisos con registros
        *   Ordenados de forma descendente segun su estado.
    */
    public function getPermissions($status)
    {
        if (auth()->user()->hasPermission('ver-listado-de-permisos')):
            switch ($status)
            {
                case '1':
                    $permissions = Permission::orderBy('id', 'DESC')->paginate(8);
                    break;
                case 'trash':
                    $permissions = Permission::onlyTrashed()->orderBy('id', 'DESC')->paginate(8);
                    break;
                case 'all':
                    $permissions = Permission::withTrashed()->orderBy('id', 'DESC')->paginate(8);
                    break;
            }

            $data = [
              'permissions' => $permissions
            ];

            return view('admin.permissions.home', $data);
        else:
            abort(403);
        endif;
    }

    /*
        *   Visualización de la vista de editar un permiso con registro
        *   a modificar.
    */
    public function getPermissionEdit($id)
    {
        if (auth()->user()->hasPermission('editar-permisos')):
            $permission = Permission::findOrFail($id);
            $roles = Role::all();
            $data = [
                'p' => $permission,
                'r' => $roles,
            ];
            return view('admin.permissions.permission_edit', $data);
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de modificar un permiso con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function postPermissionEdit(Request $request, $id)
    {
        if (auth()->user()->hasPermission('editar-permisos')):
            $permission = Permission::findOrFail($id);
            #$permission->name = $request->input('name');
            #$permission->slug = Str::lower(str_replace(' ','-',$request->input('name')));
            $permission->description = $request->input('description');

            $rules = [
                #'name' => 'required|max:20|unique:permissions|regex:/^[a-zA-Z ]{1,20}$/',
                'description' => 'required|max:50|regex:/^[a-zA-Z ]{1,50}$/'
            ];

            $messages = [
                #'name.required' => 'El nombre del permiso es requerido',
                #'name.max' => 'El nombre del permiso debe contener al menos 20 caracteres',
                #'name.unique' => 'No se puede ingresar un nombre ya existente',
                #'name.regex' => 'El nombre del permiso solo debe contener palabras y no sobrepasar las 20 caracteres',
                'description.required' => 'La descripcion del permiso es requerida',
                'description.regex' => 'La descripción del permiso solo debe contener palabras y no sobrepasar las 50 caracteres',
                'description.max' => 'El descripción del permiso debe contener al menos 50 palabras'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()):
                return back()->withErrors($validator)
                    ->with('message', 'Se ha producido un error')
                    ->with('typealert', 'danger')
                    ->withInput();

            elseif($permission->save()):
                $permission->role = $request->input('rol');
                $permission->roles()->sync($permission->role);

                return redirect('/admin/permission/'.$permission->id.'/edit')
                    ->with('message', 'Se ha actualizado el Permiso')
                    ->with('typealert', 'success');
                #if($permission->id == 1 || $permission->id == 2 || $permission->id == 3 || $permission->id == 4 || $permission->id == 5
                #|| $permission->id == 6 || $permission->id == 7 || $permission->id == 8 || $permission->id == 9 || $permission->id == 10
                #|| $permission->id == 11 || $permission->id == 12 || $permission->id == 13):
                #    return redirect('/admin/permission/'.$permission->id.'/edit')
                #        ->with('message', 'Por motivos de seguridad no puedes modificar el Permiso:'.$permission->id)
                #        ->with('typealert', 'danger');
                #elseif ($permission->save()):
                #    $permission->role = $request->input('rol');
                #    $permission->roles()->sync($permission->role);
                #    return redirect('/admin/permission/'.$permission->id.'/edit')
                #        ->with('message', 'Se ha actualizado el Permiso')
                #        ->with('typealert', 'success');
                #endif;
            endif;
        else:
            abort(403);
        endif;
    }

    public function getPermissionAdd()
    {
        if (auth()->user()->hasPermission('agregar-nuevos-permisos')):
            return view('admin.permissions.add');
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de crear un permiso con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function postPermisssionAdd(Request $request)
    {
        if (auth()->user()->hasPermission('agregar-nuevos-permisos')):
            $rules = [
                'name' => 'required|max:20|unique:roles|regex:/^[a-zA-Z ]{1,25}$/',
                'description' => 'required|max:50|regex:/^[a-zA-Z ]{1,55}$/',
                'module' => 'required'
            ];

            $messages = [
                'name.required' => 'El nombre del permiso es requerido',
                'name.unique' => 'No se puede ingresar un nombre ya existente',
                'name.max' => 'El nombre del permiso debe contener al menos 20 caracteres',
                'name.regex' => 'El nombre del permiso solo debe contener palabras y no sobrepasar las 25 caracteres',
                'description.required' => 'La descripcion del permiso es requerida',
                'description.regex' => 'La descripción del permiso solo debe contener palabras y no sobrepasar las 50 caracteres',
                'description.max' => 'La descripcion del permiso debe contener al menos 50 palabras',
                'module.required' => 'El modulo es requerido'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()):
                return back()->withErrors($validator)
                    ->with('message', 'Se ha producido un error')
                    ->with('typealert', 'danger')
                    ->withInput();
            else:
                $permission = new Permission();
                $permission->name = e($request->input('name'));
                $permission->slug = Str::lower(str_replace(' ','-',$request->input('name')));
                $permission->description = e($request->input('description'));
                $permission->module = e($request->input('module'));

                if($permission->save()):
                    return redirect('/admin/permissions/1')
                        ->with('message', 'Guardado con exito')
                        ->with('typealert', 'success');
                endif;
            endif;
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de buscar un permiso con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function postPermissionsSearch(Request $request)
    {
        if (auth()->user()->hasPermission('buscar-permisos')):
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
                return redirect('/admin/permissions/1')->withErrors($validator)
                    ->with('message', 'Se ha producido un error')
                    ->with('typealert', 'danger')
                    ->withInput();
            else:
                switch ($request->input('filter')):
                    case '0':
                        $permissions = Permission::withTrashed()->where('name', 'LIKE', '%'.$request->input('search').'%')
                            ->orderBy('id','DESC')->get();
                        break;
                    case '1':
                        $permissions = Permission::withTrashed()->where('description', 'LIKE', '%'.$request->input('search').'%')
                            ->orderBy('id','DESC')->get();
                        break;
                endswitch;

                $data = ['permissions' => $permissions];
                return view('admin.permissions.search', $data);
            endif;
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de eliminar un permiso con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function getPermissionDelete($id)
    {
        if (auth()->user()->hasPermission('eliminar-permisos')):
            $permission = Permission::findOrFail($id);
            if($permission->delete()):
                return back()
                    ->with('message', 'El Permiso fue enviado a la papelera con exito')
                    ->with('typealert' , 'success');
            endif;
        else:
            abort(403);
        endif;
    }

    /*
        *   Accion de restaurar un permiso con las reglas a aplicar
        *   los mensajes correspondientes para realizar la accion.
    */
    public function getPermissionRestore($id)
    {
        if (auth()->user()->hasPermission('restaurar-permisos')):
            $permission = Permission::onlyTrashed()->where('id',$id)->first();
            if($permission->restore()):
                return redirect('/admin/permission/'.$permission->id.'/edit')
                    ->with('message', 'Este Permiso se restauro satisfactoriamente')
                    ->with('typealert', 'success');
            endif;
        else:
            abort(403);
        endif;
    }

    /*
        *   Visualizacion del historial de un permiso desde que se creo
        *   modifico, elimino y restauro.
    */
    public function getPermissionAuditing($id)
    {
        if (auth()->user()->hasPermission('historial-de-permisos')):
            $permission = CollectionHelper::paginate(Permission::findOrFail($id)->audits->load('user'),5);
            $data = [
                'history' => $permission,
            ];
            return view('admin.permissions.auditing', $data);
        else:
            abort(403);
        endif;
    }
}
