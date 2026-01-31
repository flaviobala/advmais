<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutEvent;
use App\Models\AboutFounder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $events = AboutEvent::orderBy('order')->get();
        $founders = AboutFounder::orderBy('order')->get();

        return view('admin.about.index', compact('events', 'founders'));
    }

    public function storeEvent(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'video_url' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('about/events', 'public');
        }

        $data['order'] = (AboutEvent::max('order') ?? -1) + 1;

        AboutEvent::create($data);

        return back()->with('success', 'Evento adicionado com sucesso!');
    }

    public function destroyEvent(AboutEvent $event)
    {
        if ($event->photo) {
            Storage::disk('public')->delete($event->photo);
        }

        $event->delete();

        return back()->with('success', 'Evento excluído com sucesso!');
    }

    public function storeFounder(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:5000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('about/founders', 'public');
        }

        $data['order'] = (AboutFounder::max('order') ?? -1) + 1;

        AboutFounder::create($data);

        return back()->with('success', 'Idealizador adicionado com sucesso!');
    }

    public function updateFounder(Request $request, AboutFounder $founder)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:5000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        unset($data['photo']);

        if ($request->hasFile('photo')) {
            if ($founder->photo) {
                Storage::disk('public')->delete($founder->photo);
            }
            $data['photo'] = $request->file('photo')->store('about/founders', 'public');
        } elseif ($request->input('remove_photo') == '1') {
            if ($founder->photo) {
                Storage::disk('public')->delete($founder->photo);
            }
            $data['photo'] = null;
        }

        $founder->update($data);

        return back()->with('success', 'Idealizador atualizado com sucesso!');
    }

    public function destroyFounder(AboutFounder $founder)
    {
        if ($founder->photo) {
            Storage::disk('public')->delete($founder->photo);
        }

        $founder->delete();

        return back()->with('success', 'Idealizador excluído com sucesso!');
    }
}
