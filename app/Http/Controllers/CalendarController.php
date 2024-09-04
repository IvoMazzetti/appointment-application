<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Service;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CalendarController extends Controller
{
    public $userId = null;

    public function index() {
        $this->userId = Auth::user()->getAuthIdentifier();
        return Inertia::render('Calendar/Index', []);
    }

    public function getServices() {
        $services = Service::all();

        return response()->json($services);
    }

    public function getAvailableSlots(Request $request)
    {
        $date = $request->input('date');

        $company = $this->getCompany($request->user()->id);
        if (!$company) {
            return response()->json(['error' => 'Empresa não encontrada'], 404);
        }

        $appointments = $this->getAppointments($company->id, $date);

        $bookedSlots = $this->calculateBookedSlots($appointments);

        $availableSlots = $this->generateAvailableSlots($bookedSlots);

        return response()->json($availableSlots);
    }

    private function getCompany($userId)
    {
        return Company::where('user_id', $userId)->first();
    }

    private function getAppointments($companyId, $date)
    {
        return Appointment::where('company_id', $companyId)
            ->where('date', $date)
            ->with('service')
            ->get(['time', 'service_id']);
    }

    private function calculateBookedSlots($appointments)
    {
        $bookedSlots = [];

        foreach ($appointments as $appointment) {
            $serviceDuration = $appointment->service->duration;
            $startSlot = new DateTime($appointment->time);
            $endSlot = (clone $startSlot)->add(new DateInterval('PT' . $serviceDuration . 'M'));

            for ($currentSlot = $startSlot; $currentSlot < $endSlot; $currentSlot->add(new DateInterval('PT30M'))) {
                $bookedSlots[$currentSlot->format('H:i:s')] = true; // Use `true` for booked slots
            }
        }

        return $bookedSlots;
    }

    private function generateAvailableSlots($bookedSlots)
    {
        $availableSlots = [];
        $startTime = new DateTime('08:00');
        $endTime = new DateTime('18:00');
        $interval = new DateInterval('PT30M');

        for ($currentTime = $startTime; $currentTime <= $endTime; $currentTime->add($interval)) {
            $timeSlot = $currentTime->format('H:i:s');
            if (!isset($bookedSlots[$timeSlot])) {
                $availableSlots[] = $timeSlot;
            }
        }

        return $availableSlots;
    }




}
