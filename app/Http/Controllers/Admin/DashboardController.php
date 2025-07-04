<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalPosts = Post::count();
        $totalUsers = User::count();
        $thisMonthPosts = Post::whereMonth('created_at', Carbon::now()->month)->count();
        
        // For now, we'll set total views to 0 (you can implement view tracking later)
        $totalViews = 0;
        
        // Get recent posts
        $recentPosts = Post::latest()->take(10)->get();
        
        return view('admin.dashboard', compact(
            'totalPosts',
            'totalUsers', 
            'thisMonthPosts',
            'totalViews',
            'recentPosts'
        ));
    }
}
