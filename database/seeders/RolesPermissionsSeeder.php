<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertPermissions();
        $this->insertRoles();
        $this->AdminPermissions();
        $this->CoordinadorPermissions();
        $this->Estudent();
        $this->Docente();
    }

    public function insertPermissions(): void
    {
        $now = now();
        $permissions = [
            //Permisos para DASHBOARD
            ['Ver Dashboard', 'ver-dashboard', 'Visualizar DASHBOARD', 'dashboard'],
            ['Ver estadisticas rapidas' , 'ver-estadisticas-rapidas', 'Visualizar Estadisticas Rapidas', 'dashboard'],
            ['Ver graficas' , 'ver-graficas', 'Visualizar graficas', 'dashboard'],
            //Permisos para Roles
            ['Ver listado de roles', 'ver-listado-de-roles', 'Visualizar Roles','roles'],
            ['Agregar nuevos roles', 'agregar-nuevos-roles', 'Puede Agregar Roles','roles'],
            ['Editar roles', 'editar-roles', 'Puede Editar Roles','roles'],
            ['Buscar roles', 'buscar-roles', 'Puede Buscar Roles','roles'],
            ['Eliminar roles', 'eliminar-roles', 'Puede Eliminar Roles','roles'],
            ['Restaurar roles', 'restaurar-roles', 'Puede Restaurar Roles','roles'],
            ['Historial de roles', 'historial-de-roles', 'Visualizar Historial de Roles','roles'],
            //Permisos para 'Slider'
            ['Ver listado de Slider', 'ver-slider', 'Visualizar Sliders', 'slider'],
            //Permisos para 'Permisos'
            ['Ver listado de permisos', 'ver-listado-de-permisos', 'Visualizar Permisos','permisos'],
            ['Agregar nuevos permisos', 'agregar-nuevos-permisos', 'Puede Agregar Permisos','permisos'],
            ['Editar permisos', 'editar-permisos', 'Puede Editar Permisos','permisos'],
            ['Buscar permisos', 'buscar-permisos', 'Puede Buscar Permisos','permisos'],
            ['Eliminar permisos', 'eliminar-permisos', 'Puede Eliminar Permisos','permisos'],
            ['Restaurar permisos', 'restaurar-permisos', 'Puede Restaurar Permisos','permisos'],
            ['Historial de  permisos', 'historial-de-permisos', 'Visualizar Historial de Permisos','permisos'],
            //Permisos para 'Usuarios'
            ['Ver listado de usuarios', 'ver-listado-de-usuarios', 'Visualizar Usuarios','usuarios'],
            ['Agregar nuevos usuarios', 'agregar-nuevos-usuarios', 'Puede Agregar Usuarios','usuarios'],
            ['Editar roles de usuarios', 'editar-roles-de-usuarios', 'Puede Editar Roles de Usuarios','usuarios'],
            ['Editar permisos de usuarios', 'editar-permisos-de-usuarios', 'Puede Editar Permisos de Usuarios','usuarios'],
            ['Buscar usuarios', 'buscar-usuarios', 'Puede Buscar Usuarios','usuarios'],
            ['Eliminar usuarios', 'eliminar-usuarios', 'Puede Eliminar Usuarios','usuarios'],
            ['Restaurar usuarios', 'restaurar-usuarios', 'Puede Restaurar Usuarios','usuarios'],
        ];

        $permissions = array_map(function ($permission) use ($now){
            return [
                'name' => $permission[0],
                'slug' => $permission[1],
                'description' => $permission[2],
                'module' => $permission[3],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $permissions);

        DB::table('permissions')->insert($permissions);
    }

    public function insertRoles(): void
    {
        $now = now();
        $roles = [
            ['Administrador', 'administrador', 'Usuario Administrador'],
            ['Coordinador', 'coordinador', 'Usuario Coordinador'],
            ['Profesor', 'profesor', 'Usuario Profesor'],
            ['Estudiante', 'estudiante', 'Usuario Estudiante'],
        ];

        $roles = array_map(function ($role) use ($now){
            return [
                'name' => $role[0],
                'slug' => $role[1],
                'description' => $role[2],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $roles);

        DB::table('roles')->insert($roles);
    }

    public function AdminPermissions(): void
    {
        $admin = Role::find(1);
        $permissions = Permission::all();

        $admin->permissions()->sync($permissions);

        $now = now();
        $user_groups = [
            ['190018180','0', 'Alberto', 'alberto.navarrete02@inacapmail.cl','AlbNav_1',Str::random(10)],
            ['204653453','0', 'Alexander', 'alexander.orellana02@inacapmail.cl','AleOre_1',Str::random(10)],
            ['111111111','0', 'Administrador', 'administrador@inacapmail.cl','AdmAdm_1',Str::random(10)],
            ['222222222','0', 'Coordinador', 'coordinador@inacapmail.cl', 'CorCor_1', Str::random(10)],
            ['333333333','0', 'Docente', 'docente@inacapmail.cl', 'DocDoc_1', Str::random(10)]
        ];

        $user_groups = array_map(function ($user_group) use ($now){
            return [
                'rut' => $user_group[0],
                'status' => $user_group[1],
                'name' => $user_group[2],
                'email' => $user_group[3],
                'password' => bcrypt($user_group[4]),
                'remember_token' => $user_group[5],
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $user_groups);

        DB::table('users')->insert($user_groups);

        $user_i = User::find(3);

        $user_i->roles()->sync($admin);
        $user_i->permissions()->sync($permissions);
    }

    public function CoordinadorPermissions(): void
    {
        $user_c = User::find(4);
        $coord = Role::find(2);
        $permissions = Permission::whereIn('id',[1,2,3])->get();

        $user_c->roles()->sync($coord);
        $coord->permissions()->sync($permissions);
    }

    public function Estudent(): void
    {
        $user_a = User::find(2);
        $est = Role::find(4);
        $user_a->roles()->sync($est);

        $user_b = User::find(1);
        $user_b->roles()->sync($est);
    }

    public function Docente(): void
    {
        $user_d = User::find(5);
        $doc = Role::find(3);
        $user_d->roles()->sync($doc);
    }
}
