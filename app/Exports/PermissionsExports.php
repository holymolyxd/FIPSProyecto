<?php


namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class PermissionsExports implements FromCollection,WithHeadings
{
    public
    function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Descripcion',
            'Modulo asociado',
            'Fecha de creacion'
        ];
    }

    public function collection()
    {
        $permissions = DB::table('permissions')
            ->select('id', 'name', 'description', 'module', 'created_at')->get();

        return $permissions;

    }
}
