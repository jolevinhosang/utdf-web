<?php

namespace App\Http\Controllers;

use App\Models\HomeSection;
use Illuminate\Support\Facades\View;

abstract class Controller
{
    public function __construct()
    {
        // Share all home section contents with all views
        $sections = HomeSection::all()->keyBy('section_key');
        View::share('homeSections', $sections);
    }
}
