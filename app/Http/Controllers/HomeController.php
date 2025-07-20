<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home()
    {

        $currentDateTime = Carbon::now()->format('D d M Y, h:i A');

        return Inertia::render('Welcome', [
            'currentDateTime' => $currentDateTime,
        ]);
    }

    public function support() {

        return Inertia::render('Support');
    }
}
