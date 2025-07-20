<?php

namespace App\Http\Controllers;

use App\Models\Confession;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrowseController extends Controller
{
    public function browse(Request $request)
    {
        $search = $request->query('search');

        $confessions = Confession::when($search, function ($query, $search) {
            $query->where('recipient_name', 'like', '%' . $search . '%');
        })
            ->latest()
            ->get();

        return Inertia::render('Browse', [
            'confessions' => $confessions,
            'search' => $search,
        ]);
    }

    public function detail($id)
    {
        $confession = Confession::findOrFail($id);

        return Inertia::render('Detail', [
            'confession' => $confession,
        ]);
    }
}
