<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AboutEvent;
use App\Models\AboutFounder;
use App\Models\AboutSetting;

class AboutController extends Controller
{
    public function index()
    {
        $settings = AboutSetting::instance();
        $founders = AboutFounder::orderBy('order')->get();

        // Eventos são conteúdo exclusivo: só logados com acesso
        $canViewEvents = false;
        $events = collect();

        if (auth()->check()) {
            $user = auth()->user();
            $isAdmin = in_array($user->role, ['admin', 'professor']);
            $hasCategories = $user->categories()->exists();

            if ($isAdmin || $hasCategories) {
                $canViewEvents = true;
                $events = AboutEvent::orderBy('order')->get();
            }
        }

        return view('about', compact('settings', 'events', 'founders', 'canViewEvents'));
    }
}
