<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all()->where('company_id', Auth::user()->getAuthIdentifier());
        return Inertia::render('Service/Index', [
            'services' => $services
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|regex:/^\d{2}:\d{2}$/',
            'price' => 'required|numeric',
        ]);

        $validated['duration'] = $this->convertTimeToMinutes($validated['duration']);
        $validated['company_id'] = Auth::user()->getAuthIdentifier();

        $service = new Service();
        $service->fill($validated);
        $service->save();

        // Redirect or return a response
        return redirect()->route('service.index')->with('success', 'Service created successfully.');
    }

    private function convertTimeToMinutes($time): float|int
    {
        if (preg_match('/^(\d{2}):(\d{2})$/', $time, $matches)) {
            $hours = (int)$matches[1];
            $minutes = (int)$matches[2];
            return ($hours * 60) + $minutes;
        }

        // Return 0 or handle invalid time format as needed
        return 0;
    }

}
