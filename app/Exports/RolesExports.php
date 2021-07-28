<?php


namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RolesExports implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Descripcion',
            'Fecha de creacion'
        ];
    }

    public function collection()
    {
        $roles = DB::table('roles')
            ->select('id', 'name','description','created_at')->get();

        return $roles;
    }
}
