<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardDataController extends Controller
{
    /**
     * Retrieve service data in JSON format.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function services()
    {
        // Calls the getTicketData method for 'service' type
        return $this->getTicketData('service', 'service');
    }

    /**
     * Retrieve product data in JSON format.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function products()
    {
        // Calls the getTicketData method for 'product' type
        return $this->getTicketData('product', 'product');
    }

    /**
     * Retrieve the percentage of services and products sales in the last month.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function monthTransactions()
    {
        // Obtener el total de transacciones de servicios y productos para el mes actual
        $servicesTotal = $this->calculateTotal(
            Ticket::whereJsonContains('type', 'service')
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->get(),
            'service'
        );

        $productsTotal = $this->calculateTotal(
            Ticket::whereJsonContains('type', 'product')
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->get(),
            'product'
        );

        // Calcular el total general
        $totalTransactions = $servicesTotal + $productsTotal;

        // Retornar la respuesta en formato JSON
        return response()->json([
            'total' => price_formatted($totalTransactions), // Total de transacciones (formateado)
            'services_total' => price_formatted($servicesTotal), // Total de servicios
            'products_total' => price_formatted($productsTotal), // Total de productos
            'services_percentage' => $totalTransactions > 0 ? round(($servicesTotal / $totalTransactions) * 100, 1) : 0, // Porcentaje de servicios
            'products_percentage' => $totalTransactions > 0 ? round(($productsTotal / $totalTransactions) * 100, 1) : 0,  // Porcentaje de productos
        ]);
    }

    /**
     * Retrive the clients with the most recent transactions.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function recentTransactions()
    {
        
    }

    /**
     * Intermediate function that calculates data for any type of ticket.
     *
     * @param string $type The type of ticket ('service' or 'product')
     * @param string $key The key to search in ticket details ('service' or 'product')
     * @return \Illuminate\Http\JsonResponse
     */
    private function getTicketData(string $type, string $key)
    {
        // Fetch current month's tickets based on the specified type
        $ticketsCurrentMonth = Ticket::whereJsonContains('type', $type)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->get();

        // Fetch last month's tickets based on the specified type
        $ticketsLastMonth = Ticket::whereJsonContains('type', $type)
            ->whereBetween('created_at', [now()->startOfMonth()->subMonth(), now()->endOfMonth()->subMonth()])
            ->get();

        // Calculate the total price for the current month
        $totalCurrentMonth = $this->calculateTotal($ticketsCurrentMonth, $key);

        // Calculate the total price for the last month
        $totalLastMonth = $this->calculateTotal($ticketsLastMonth, $key);

        // Calculate the percentage change only if there were sales last month
        $percentage = $this->calculatePercentage($totalCurrentMonth, $totalLastMonth);

        // Return the result in JSON format
        return response()->json([
            'total_price' => price_formatted($totalCurrentMonth), // Format the total price
            'percentage' => $percentage > 0
                ? "<p class='text-success ms-2 mb-0 font-weight-medium'>+$percentage%</p>" // Positive change
                : "<p class='text-danger ms-2 mb-0 font-weight-medium'>$percentage%</p>", // Negative change
            'message' => $percentage > 0
                ? "Incremento de $percentage% del mes pasado" // Increase message
                : "Decremento de $percentage% del mes pasado", // Decrease message
        ]);
    }

    /**
     * Function that calculates the percentage of services and products sales in the last month.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    private function calculatePercentage(float $totalCurrentMonth, float $totalLastMonth)
    {
        // Calculate the percentage change only if there were sales last month
        return ($totalLastMonth > 0)
            ? round(($totalCurrentMonth - $totalLastMonth) / $totalLastMonth * 100, 1)
            : 0;
    }

    /**
     * Function that calculates the total prices of tickets based on the detail key.
     *
     * @param \Illuminate\Support\Collection $tickets Collection of tickets
     * @param string $key The detail key ('service' or 'product')
     * @return float The calculated total
     */
    private function calculateTotal($tickets, $key)
    {
        // Map over the tickets to calculate the total price based on the key
        return $tickets->map(function ($ticket) use ($key) {
            $ticketDetails = json_decode($ticket->ticket_details, true); // Decode ticket details

            // Filter items that contain the provided key ('service' or 'product')
            return collect($ticketDetails)->filter(function ($item) use ($key) {
                return isset($item[$key]);
            })->sum(function ($item) {
                // Calculate total for each item (quantity * unit price)
                return $item['quantity'] * $item['unit_price'];
            });
        })->sum(); // Sum all the calculated totals
    }
}
