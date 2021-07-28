<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrador');
    }

    public function getRegions()
    {
        $regions = Region::orderBy('id', 'DESC')->paginate(8);
        $data = ['regions' => $regions];
        return view('admin.regions.home', $data);
    }
}
