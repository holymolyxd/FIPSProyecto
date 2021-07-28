<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Permission;
use App\Models\Subject;
use App\Models\Venue;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Exports\UsersExports;
use App\Exports\RolesExports;
use App\Exports\PermissionsExports;
use Maatwebsite\Excel\Facades\Excel;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrador,coordinador');
    }

    public function getDashboard()
    {
        if(auth()->user()->hasPermission('ver-dashboard') && (auth()->user()->hasPermission('ver-estadisticas-rapidas') || auth()->user()->hasPermission('ver-graficas'))):
            $users = User::count();
            $roles = Role::count();
            $permissions = Permission::count();
            $venues = Venue::count();
            $careers = Career::count();
            $subjects = Subject::count();

            $Userchart = (new LarapexChart)->donutChart()
                ->setTitle('Usuarios registrados')
                ->addData([
                    DB::table('role_user')->where('role_id','=','1')->count(),
                    DB::table('role_user')->where('role_id','=','2')->count(),
                    DB::table('role_user')->where('role_id','=','3')->count(),
                    DB::table('role_user')->where('role_id','=','4')->count(),
                    DB::table('role_user')->whereNotBetween('role_id', [1, 4])->count()
                ])
                ->setColors(['#ffc63b', '#ff6384', '#808000','#00FF00','#00FFFF','#FF00FF'])
                ->setLabels(['Administrador','Coordinador','Profesor','Estudiante','Otros']);

            $Postchart = (new LarapexChart)->lineChart()
                ->setTitle('Publicaciones creadas.')
                ->addData('Publicaciones del 2020', [
                    DB::table('posts')->whereMonth('created_at','=',1)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',2)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',3)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',4)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',5)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',6)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',7)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',8)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',9)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',10)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',11)->whereYear('created_at','=','2020')->count(),
                    DB::table('posts')->whereMonth('created_at','=',12)->whereYear('created_at','=','2020')->count(),
                    ])
                ->addData('Publicaciones del 2021', [
                    DB::table('posts')->whereMonth('created_at','=',1)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',2)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',3)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',4)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',5)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',6)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',7)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',8)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',9)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',10)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',11)->whereYear('created_at','=','2021')->count(),
                    DB::table('posts')->whereMonth('created_at','=',12)->whereYear('created_at','=','2021')->count(),
                    ])
                    ->setColors(['#ffc63b', '#ff6384'])
                    ->setXAxis(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']);

            $Commentchart = (new LarapexChart)->lineChart()
                ->setTitle('Comentarios creados.')
                ->addData('Comentarios del 2020', [
                    DB::table('comments')->whereMonth('created_at','=',1)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',2)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',3)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',4)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',5)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',6)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',7)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',8)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',9)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',10)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',11)->whereYear('created_at','=','2020')->count(),
                    DB::table('comments')->whereMonth('created_at','=',12)->whereYear('created_at','=','2020')->count(),
                ])
                ->addData('Comentarios del 2021', [
                    DB::table('comments')->whereMonth('created_at','=',1)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',2)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',3)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',4)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',5)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',6)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',7)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',8)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',9)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',10)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',11)->whereYear('created_at','=','2021')->count(),
                    DB::table('comments')->whereMonth('created_at','=',12)->whereYear('created_at','=','2021')->count(),
                ])
                ->setColors(['#ffc63b', '#ff6384'])
                ->setXAxis(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']);

            $data = [
                'users' => $users,
                'roles' => $roles,
                'permissions' => $permissions,
                'venues' => $venues,
                'careers' => $careers,
                'subjects' => $subjects,
                'Userchart' => $Userchart,
                'Postchart' => $Postchart,
                'Commentchart' => $Commentchart,
            ];
            return view('admin.dashboard', $data);
        elseif (auth()->user()->hasPermission('ver-dashboard')):
            return view('admin.dashboard_empty');
        else:
            abort(403);
        endif;
    }

    public function reportUsers()
    {
        return Excel::download(new UsersExports, 'users.xlsx');
    }

    public function reportRoles()
    {
        return Excel::download(new RolesExports, 'roles.xlsx');
    }

    public function reportPermissions()
    {
        return Excel::download(new PermissionsExports, 'permissions.xlsx');
    }
}
