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
        // Statistics
        $stats = [
            'total_projects' => \App\Models\Project::count(),
            'total_products' => \App\Models\Product::count(),
            'total_clients' => \App\Models\Client::count(),
            'total_materials' => \App\Models\Material::count()
        ];


        
        // Get recent clients
        $recentClients = \App\Models\Client::latest()->take(5)->get();
        
        // Get recent products
        $recentProducts = \App\Models\Product::latest()->take(5)->get();
        
        // Get recent items
        $recentItems = \App\Models\Item::latest()->take(5)->get();

        // Get statistics for each category
        $categoryStats = [
            'clients' => [
                'total' => \App\Models\Client::count(),
                'recent' => $recentClients
            ],
            'products' => [
                'total' => \App\Models\Product::count(),
                'recent' => $recentProducts
            ],
            'items' => [
                'total' => \App\Models\Item::count(),
                'recent' => $recentItems
            ]
        ];

        // Recent Projects
        $recentProjects = \App\Models\Project::with(['client'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Activities
        $recentActivities = \App\Models\Project::with(['client', 'createdBy'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($project) {
                return [
                    'user' => $project->createdBy->name,
                    'action' => 'created a new project',
                    'project' => $project->project_name,
                    'created_at' => $project->created_at->format('M d, Y')
                ];
            });

        // Project Statistics
        $projectStats = [
            'total_projects' => \App\Models\Project::count(),
            'active_projects' => \App\Models\Project::where('technical_approval', 'pending')->count(),
            'completed_projects' => \App\Models\Project::where('technical_approval', 'approved')->count(),
            'technical_pending' => \App\Models\Project::where('technical_approval', 'pending')->count(),
        ];

        // Recent Projects
        $recentProjects = \App\Models\Project::with(['client'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Activities
        $recentActivities = \App\Models\Project::with(['client', 'createdBy'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($project) {
                return [
                    'user' => $project->createdBy->name,
                    'action' => 'created a new project',
                    'project' => $project->project_name,
                    'created_at' => $project->created_at->format('M d, Y')
                ];
            });

        // Project Timeline Data for Chart
        $projectTimeline = \App\Models\Project::select(
            \DB::raw('DATE(created_at) as date'),
            \DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy(\DB::raw('DATE(created_at)'))
        ->get()
        ->mapWithKeys(function($item) {
            return [$item->date->format('Y-m-d') => $item->count];
        })
        ->toArray();

        // Project Status Distribution
        $projectStatus = [
            'need_modify' => \App\Models\Project::where('technical_approval', 'need_modify')->count(),
            'dismissed' => \App\Models\Project::where('technical_approval', 'dismissed')->count()
        ];

        return view('home', compact('stats', 'recentProjects', 'recentActivities', 'projectStats', 'projectTimeline', 'projectStatus', 'categoryStats'));
    }

    // Add a method to get timeline data for AJAX requests
    public function getTimelineData()
    {
        $timelineData = \App\Models\Project::select(
            \DB::raw('DATE(created_at) as date'),
            \DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('created_at')
        ->get()
        ->mapWithKeys(function($item) {
            return [$item->date => $item->count];
        });

        return response()->json($timelineData);
    }
}
