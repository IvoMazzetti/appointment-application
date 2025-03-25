<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Company;
use Illuminate\Http\Request;
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
            'phone' => 'required|integer',
            'email' => 'nullable|string',
            'notes' => 'nullable|string',
            'day' => 'required|date',
            'time' => 'required|date_format:H:i:s',
        ]);

        $company = $this->getCompany(request()->user()->id);
        $validated = array_merge($validated, [
            'company_id' => $company->id,
            'service_id' => $validated['service'],
            'terms_and_conditions' => true,
            'date' => $validated['day'],
        ]);
        unset($validated['service']);

        Appointment::create($validated);

        return redirect()->route('appointment.index')->with('success', 'Service created successfully.');
    }

    private function getCompany($userId)
    {
        return Company::where('user_id', $userId)->first();
    }

}
