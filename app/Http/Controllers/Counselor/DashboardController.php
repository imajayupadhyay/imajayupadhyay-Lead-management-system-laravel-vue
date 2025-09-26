<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the counselor dashboard.
     */
    public function index(): Response
    {
        return Inertia::render('Counselor/Dashboard', [
            'user' => auth()->user(),
        ]);
    }
}