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
    public function index() {
        $company = $this->getCompany(request()->user()->id);
        session(['companyId' => $company->id]);
        return Inertia::render('Calendar/Index', [
            'companyId' => $company->id,
        ]);
    }

    public function getServices() {
        $services = Service::all();

        return response()->json($services);
    }

    private function getCompany($userId)
    {
        return Company::where('user_id', $userId)->first();
    }

    public function getAvailableSlots(Request $request)
    {
        $date = $request->input('date');
        $companyId = session('companyId');

        $appointments = Appointment::where('company_id', $companyId)
            ->where('date', $date)
            ->with('service')
            ->get(['time', 'service_id']);

        $availableSlots = $this->getSlots($appointments);

        return response()->json($availableSlots);
    }



    private function getAppointments($companyId, $startDate = null, $endDate = null)
    {
        return Appointment::with('service:id,name,duration')
            ->where('company_id', $companyId)
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('date', [$startDate, $endDate]))
            ->when($startDate && !$endDate, fn($q) => $q->whereDate('date', $startDate))
            ->get(['name', 'date', 'time', 'service_id'])
            ->map(function ($appointment) {
                $startTime = new DateTime($appointment->time);
                $endTime = (clone $startTime)->modify("+{$appointment->service->duration} minutes");

                return [
                    'name' => $appointment->name,
                    'date' => $appointment->date,
                    'start_time' => $startTime->format('H:i'),
                    'end_time' => $endTime->format('H:i'),
                    'service_name' => $appointment->service->name,
                ];
            });
    }

    private function calculateBookedSlots($appointments)
    {
        $bookedSlots = [];

        foreach ($appointments as $appointment) {
            $serviceDuration = $appointment->service->duration;
            $serviceName = $appointment->service->name;
            $appointmentName = $appointment->name;
            $startSlot = new DateTime($appointment->time);
            $endSlot = (clone $startSlot)->add(new DateInterval('PT' . $serviceDuration . 'M'));

            for ($currentSlot = $startSlot; $currentSlot < $endSlot; $currentSlot->add(new DateInterval('PT30M'))) {
                $timeSlot = $currentSlot->format('H:i:s');
                $bookedSlots[] = [
                    'time' => $timeSlot,
                    'serviceName' => $serviceName,
                    'appointmentName' => $appointmentName,
                    'start' => $startSlot->format('Y-m-d H:i:s'),
                    'end' => $endSlot->format('Y-m-d H:i:s'),
                ];
            }
        }

        return $bookedSlots;
    }

    private function generateAvailableSlots($bookedSlots)
    {
        $availableSlots = [];
        $startTime = new DateTime('08:00');
        $endTime = new DateTime('18:00');
        $interval = new DateInterval('PT30M'); // 30-minute intervals

        // Iterate over the time range from 08:00 to 18:00
        for ($currentTime = $startTime; $currentTime < $endTime; $currentTime->add($interval)) {
            $isAvailable = true;
            $currentSlotTime = $currentTime->format('H:i:s');

            // Check if the current slot overlaps with any booked slots
            foreach ($bookedSlots as $bookedSlot) {
                $bookedStart = new DateTime($bookedSlot['start']);
                $bookedEnd = new DateTime($bookedSlot['end']);

                // If current time overlaps with a booked slot, mark it as unavailable
                if ($currentTime >= $bookedStart && $currentTime < $bookedEnd) {
                    $isAvailable = false;
                    break;
                }
            }

            // If the current time slot is available, add it to the list
            if ($isAvailable) {
                $availableSlots[] = $currentSlotTime;
            }
        }

        return $availableSlots;
    }



    public function getSlots($appointments)
    {
        $bookedSlots = $this->calculateBookedSlots($appointments);

        return $this->generateAvailableSlots($bookedSlots);
    }


    public function getBookedSlots(Request $request)
    {
        $date = new DateTime();
        $companyId = $request->query('companyId');

        $startWeekDay = (clone $date)->modify('monday this week')->format('Y-m-d');
        $endWeekDay = (clone $date)->modify('sunday this week')->format('Y-m-d');

        if (!isset($companyId)) {
            return response()->json(['error' => 'Empresa não encontrada'], 404);
        }

        $appointments = $this->getAppointments($companyId, $startWeekDay, $endWeekDay);


        return response()->json([
            'startWeekDay' => $startWeekDay,
            'endWeekDay' => $endWeekDay,
            'appointments' => $appointments
        ]);
    }

}
