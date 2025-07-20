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
        $page = $request->query('page', 1);
        $perPage = 4; // Jumlah data per halaman

        $confessions = Confession::when($search, function ($query, $search) {
            $query->where('recipient_name', 'like', '%' . $search . '%');
        })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        // Untuk initial load (Inertia response)
        return Inertia::render('Browse', [
            'confessions' => $confessions->items(),
            'search' => $search,
            'hasMore' => $confessions->hasMorePages(),
            'currentPage' => $confessions->currentPage(),
            'totalPages' => $confessions->lastPage()
        ]);
    }

    // Method terpisah untuk AJAX infinite scroll
    public function loadMore(Request $request)
    {
        $search = $request->query('search');
        $page = $request->query('page', 1);
        $perPage = 4;

        $confessions = Confession::when($search, function ($query, $search) {
            $query->where('recipient_name', 'like', '%' . $search . '%');
        })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'confessions' => $confessions->items(),
            'hasMore' => $confessions->hasMorePages(),
            'currentPage' => $confessions->currentPage(),
            'totalPages' => $confessions->lastPage()
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
