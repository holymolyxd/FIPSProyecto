<?php


namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExports implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            'ID',
            'Rut',
            'Nombre',
            'Correo electronico',
            'Rol',
            'Telefono',
            'Fecha de nacimiento',
            'Genero',
            'Direccion',
            'Comuna',
            'Region',
            'Sede',
            'Carrera',
            'Fecha de creacion'
        ];
    }

    public function collection()
    {
        $users = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->join('roles','role_user.role_id','=','roles.id')
            ->join('genders','genders.id','=','users.gender_id')
            ->join('communes','communes.id','=','users.commune_id')
            ->join('regions','regions.id','=','communes.region_id')
            ->join('venues','venues.id','=','users.venue_id')
            ->leftJoin('careers','careers.id','=','users.career_id')
        ->select('users.id as user_id','rut','users.name as user_name','users.email as user_email','roles.name as role_name',
        'users.phone as user_phone','birthdate','genders.name as gender_name','adress','communes.gloss_commune as commune_name',
        'regions.gloss_region as region_name','venues.name as venue_name','careers.name as career_name','users.created_at as user_creacion')
            ->get();

        return $users;
    }
}
