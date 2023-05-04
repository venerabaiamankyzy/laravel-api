<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class HomeController extends Controller
{
    public function index() {
        
        $recent_projects = Project::where('is_published', 1)->orderBy('updated_at', 'DESC')->limit(8)->get();

        // $highlighted_projects = Project::where('is_published', 1)->where('highlighted', 1)->orderBy('undated_at', 'DESC')->limit(8)->get();
        return view('guest.home', compact('recent_projects'));
    }
}