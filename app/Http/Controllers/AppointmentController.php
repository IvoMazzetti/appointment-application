<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index()
    {
        return Inertia::render('Appointment/Index', []);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service' => 'required|max:255',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'string',
            'notes' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $validated['duration'] = $this->convertTimeToMinutes($validated['duration']);
        $validated['company_id'] = Auth::user()->getAuthIdentifier();

        $service = new Appointment();
        $service->fill($validated);
        $service->save();

        // Redirect or return a response
        return redirect()->route('service.index')->with('success', 'Service created successfully.');
    }
}
