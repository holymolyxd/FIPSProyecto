<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use Illuminate\Http\Request;

class CommuneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrador');
    }

    public function getCommunes()
    {
        $communes = Commune::orderBy('id', 'DESC')->paginate(8);
        $data = ['communes' => $communes];
        return view('admin.communes.home', $data);
    }
}
