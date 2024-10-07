<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BranchOffice;
use App\Models\Gallery;
use App\Models\Purchase;
use App\Models\Ticket;
use Carbon\Carbon;
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
     * Retrieve purchase data in JSON format.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchases()
    {
        // Calls the getPurchaseData
        return $this->getPurchaseData();
    }

    /**
     * Retrieve the percentage of services and products sales in the last month.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function monthTransactions()
    {
        // Obtener el total de transacciones de servicios y productos para el mes actual
        $servicesTotal = $this->calculateTotalTickets(
            Ticket::whereJsonContains('type', 'service')
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->get(),
            'service'
        );

        $productsTotal = $this->calculateTotalTickets(
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
     * Retrieve the clients with the most recent transactions.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function serviceAndProductSales()
    {
        $tickets = Ticket::with('user')
            ->orderBy('updated_at', 'desc')
            ->get();

        $result = $tickets->map(function ($ticket) {
            return [
                'user' => $ticket->user->name,
                'ticket' => [
                    'folio' => $ticket->folio,
                    'total_price' => price_formatted($ticket->total_price),
                    'payment_method' => $ticket->payment_method,
                    'country_code' => $ticket->country_code,
                    'type' => $ticket->type,
                    'updated_at' => $ticket->updated_at->toDateTimeString(),
                    'status' => $ticket->status,
                    'class' => $this->statusClass($ticket->status),
                ]
            ];
        });

        return response()->json([
            'data' => $result,
            'message' => 'Clients with recent transactions retrieved successfully'
        ]);
    }

    /**
     * Retrieve the gallery of the current branch.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function gallery(Request $request)
    {
        // Obtener la galería de la sucursal
        $branchId = BranchOffice::select('id')->where('name', $request->branch_name)->first();
        $gallery = Gallery::select('photos')->where('branch_id', $branchId->id)->get();

        return response()->json([
            'gallery' => $gallery,
            'message' => 'Gallery retrieved successfully'
        ]);
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
        $totalCurrentMonth = $this->calculateTotalTickets($ticketsCurrentMonth, $key);

        // Calculate the total price for the last month
        $totalLastMonth = $this->calculateTotalTickets($ticketsLastMonth, $key);

        // Calculate the percentage change only if there were sales last month
        $percentage = $this->calculatePercentage($totalCurrentMonth, $totalLastMonth);

        // Return the result in JSON format
        return response()->json([
            'total_price' => price_formatted($totalCurrentMonth),
            'percentage' => $percentage > 0
                ? "<p class='text-success ms-2 mb-0 font-weight-medium'>+$percentage%</p>"
                : "<p class='text-danger ms-2 mb-0 font-weight-medium'>$percentage%</p>",
            'message' => $percentage > 0
                ? "Incremento de $percentage% del mes pasado"
                : "Decremento de $percentage% del mes pasado",
        ]);
    }

    /**
     * Intermediate function that calculates data for purchase information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPurchaseData()
    {
        // Obtener las compras del mes actual
        $startOfCurrentMonth = Carbon::now()->startOfMonth();
        $endOfCurrentMonth = Carbon::now()->endOfMonth();

        $purchasesCurrentMonth = Purchase::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])->get();

        // Obtener las compras del mes pasado
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $purchasesLastMonth = Purchase::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->get();

        // Calcular el total de costos para ambos meses
        $totalCurrentMonth = $this->calculateTotalPurchases($purchasesCurrentMonth, 'total_cost');
        $totalLastMonth = $this->calculateTotalPurchases($purchasesLastMonth, 'total_cost');

        // Calcular el porcentaje de cambio
        $percentage = $this->calculatePercentage($totalCurrentMonth, $totalLastMonth);

        return response()->json([
            'total_price' => price_formatted($totalCurrentMonth),
            'percentage' => $percentage > 0
                ? "<p class='text-danger ms-2 mb-0 font-weight-medium'>+$percentage%</p>"
                : "<p class='text-success ms-2 mb-0 font-weight-medium'>$percentage%</p>",
            'message' => $percentage > 0
                ? "Incremento de $percentage% del mes pasado"
                : "Decremento de $percentage% del mes pasado",
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
    private function calculateTotalTickets($tickets, $key)
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

    /**
     * **************************************************
     *
     * @param *************************************
     * @param string ********************************
     * @return float *********************
     */
    private function calculateTotalPurchases($purchases, $key)
    {
        return $purchases->map(function ($purchase) use ($key) {
            return $purchase->$key;
        })->sum();
    }

    /**
     * Function that returns the status class based on the ticket status.
     *
     * @param string $status The ticket status ('pending', 'in_progress', 'finished' and 'cancelled')
     * @return string The status class
     */
    private function statusClass(string $status)
    {
        switch ($status) {
            case 'pending':
                return 'badge-outline-warning';
            case 'in_progress':
                return 'badge-outline-info';
            case 'finished':
                return 'badge-outline-success';
            case 'cancelled':
                return 'badge-outline-danger';
            default:
                return '';
        }
    }
}
