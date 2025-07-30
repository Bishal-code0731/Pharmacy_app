<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        return view('activity.index', [
            'activities' => Activity::with('user')->latest()->paginate(20)
        ]);
    }
}