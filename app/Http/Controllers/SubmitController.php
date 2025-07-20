<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SubmitController extends Controller
{
    public function submit() {

        return Inertia::render('Submit');
    }
}
