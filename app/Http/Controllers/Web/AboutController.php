<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AboutEvent;
use App\Models\AboutFounder;

class AboutController extends Controller
{
    public function index()
    {
        $events = AboutEvent::orderBy('order')->get();
        $founders = AboutFounder::orderBy('order')->get();

        return view('about', compact('events', 'founders'));
    }
}
