<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnerDashboardController extends Controller
{
    public function index(){
        return Inertia::render('OwnerDashboard');
    }
}
