<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function getMonthData($year, $month)
    {
        $start = Carbon::createFromDate($year, $month, 1);
        $end = $start->copy()->endOfMonth();

        $days = [];
        while ($start <= $end) {
            $days[] = $start->format('Y-m-d');
            $start->addDay();
        }

        return response()->json($days);
    }
}
