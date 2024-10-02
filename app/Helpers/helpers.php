<?php

use Carbon\Carbon;
use App\Models\Ticket;

if (!function_exists('price_formatted')) 
{
    /**
     * Format quantity price.
     *
     * This function returns the received price formatted.
     *
     * @param float $price The price of the product.
     * @return string The price formatted.
     */
    function price_formatted(float $price)
    {
        return '$' . number_format($price, 2) . ' MXN';
    }
}

if (!function_exists('next_folio')) {
    /**
     * Generate the next folio number based on the current date and existing tickets.
     *
     * @return string The next folio in the format YYMMDD-XXXX
     */
    function next_folio()
    {
        $date = now()->format('ymd');
        $lastTicket = Ticket::whereDate('created_at', now())
                            ->orderBy('folio', 'desc') // Order by folio to get the last one of the day
                            ->first();

        if (!$lastTicket) {
            return "$date-0001"; // Return the initial folio for today
        }

        // Extract the current folio number (assuming the format is YYMMDD-XXXX)
        $lastFolioNumber = intval(substr($lastTicket->folio, -4)); // Get the last 4 digits of the folio

        // Generate the next folio by incrementing the number and formatting it with leading zeros
        $nextFolioNumber = str_pad($lastFolioNumber + 1, 4, '0', STR_PAD_LEFT);

        return "$date-$nextFolioNumber";
    }
}

if (!function_exists('current_date_spanish')) {
    /**
     * Get current date in Spanish format
     * 
     * @return string
     */
    function current_date_spanish()
    {
        // Months array in Spanish
        $months = [
            1 => 'Enero', 
            2 => 'Febrero', 
            3 => 'Marzo', 
            4 => 'Abril', 
            5 => 'Mayo', 
            6 => 'Junio', 
            7 => 'Julio', 
            8 => 'Agosto', 
            9 => 'Septiembre', 
            10 => 'Octubre', 
            11 => 'Noviembre', 
            12 => 'Diciembre'
        ];

        // Get current date
        $fecha = Carbon::now();

        $day = $fecha->day;
        $month = $months[$fecha->month];
        $year = $fecha->year;

        return "$day de $month del $year";
    }
}