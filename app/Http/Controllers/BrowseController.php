<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class BrowseController extends Controller
{
    public function browse()
    {
        return Inertia::render('Browse');
    }

    public function detail()
    {

        return Inertia::render('Detail');
    }
}
