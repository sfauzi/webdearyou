<?php

namespace App\Http\Controllers;

use App\Models\Confession;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrowseController extends Controller
{
    public function browse()
    {
        $confessions = Confession::orderBy('created_at', 'desc')->get();

        return Inertia::render('Browse', [
            'confessions' => $confessions
        ]);
    }

    public function detail($id)
    {
        $confession = Confession::findOrFail($id);

        return Inertia::render('Detail', [
            'confession' => $confession
        ]);
    }
}
