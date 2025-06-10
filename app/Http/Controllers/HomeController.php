<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Project;
use App\Models\Product;
use App\Models\Client;
use App\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stats = [
            'total_projects' => \App\Models\Project::count(),
            'total_products' => \App\Models\Product::count(),
            'total_clients' => \App\Models\Client::count(),
            'total_materials' => \App\Models\Material::count()
        ];
        return view('home', compact('stats'));
    }
}
