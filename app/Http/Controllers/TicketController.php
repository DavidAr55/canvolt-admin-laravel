<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Ticket;
use App\Models\User;
use TCPDF;

class TicketController extends Controller
{
    public function index()
    {
        return view('tickets.generate-ticket');
    }

    public function store(Request $request)
    {
        try {
            // Check if the user exist
            $user = $this->checkUser($request);

            // Generate the ticket
            $this->generateTicket($request);

            // Store the ticket
            $this->storeTicket($request, $user);

            // Send email
            $this->sendMail($request);

            // Clear the session
            Session::forget('fileName');
            Session::forget('contact');
            Session::forget('method');

            return response()->json([
                'message' => 'Formulario recibido correctamente',
                'data' => $request->all()
            ]);
        } catch (\Exception $e) {
            // Si ocurre un error, devolver una respuesta JSON
            return response()->json([
                'error' => 'Ocurrió un error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    private function checkUser($request)
    {
        // Filter contact input
        // Check if the contact is an email or a phone number
        Session::put('contact', $request->contact);
        if (filter_var($request->contact, FILTER_VALIDATE_EMAIL)) {
            Session::put('method', 'email');
        } else {
            Session::put('method', 'phone');
        }

        // Check if the user exist
        $user = User::where(Session::get('method'), $request->contact)->first();
        if (!$user) {
            // Create the user
            $user = new User();
            $user->name = $request->name;
            $user->email = Session::get('method') == 'email' ? $request->contact : 'guest-' . Str::random(32) . '@canvolt.com.mx';
            $user->phone = Session::get('method') == 'phone' ? $request->contact : null;
            $user->password = Hash::make(Str::random(16));
            $user->created_at = now();
            $user->updated_at = now();
            $user->save();
        }

        // Return the user
        return $user;
    }

    private function generateTicket($request)
    {
        /**
         * PDF dimensions width and height
         * width: 595px
         * height: 842px
         */

        $pdf = new TCPDF();
        $pdf->AddPage();

        // PDF format
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(23, 23, 23);
        $pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'F');
        $pdf->Image(public_path('images/canvolt-water-mark.png'), 25, 50, 160, 0, 'PNG');
        $pdf->Image(public_path('images/logo.png'), 5, 6, 50, 0, 'PNG');
        
        // Folio information
        $pdf->setTextColor(61, 149, 85);
        $pdf->SetFont('helvetica', 'B', 24);
        $pdf->Cell(0, 10, 'FOLIO No. ' . next_folio(), 0, 1, 'R');

        $pdf->setTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetXY(10, 25);
        $pdf->Cell(0, 5, 'C. Juan Manuel 304', 0, 1, 'L');
        $pdf->Cell(0, 5, 'Zapopan, 45100 Zapopan, Jal.', 0, 1, 'L');
        $pdf->Cell(0, 5, 'Teléfono: +52 33 3258 8070', 0, 1, 'L');
        $pdf->Cell(0, 5, 'Sitio web: www.canvolt.com.mx', 0, 1, 'L');

        // Date information
        $fecha = current_date_spanish();

        // Date information
        $anchoTextoFecha = $pdf->GetStringWidth($fecha) + 14;

        // Calculate the position in X to align to the right
        $marginRight = 1.5;
        $posXFecha = $pdf->getPageWidth() - $anchoTextoFecha - $marginRight;

        // Calculate the position of the text "FECHA:" relative to the date rectangle
        $anchoTextoEtiqueta = $pdf->GetStringWidth('FECHA:') + 5; // Width of the text "FECHA:" + margin of 2 units
        $posXEtiqueta = $posXFecha - $anchoTextoEtiqueta - 2; // Place "FECHA:" just to the left of the date rectangle

        // Set the position for "FECHA:" based on the calculated position
        $pdf->SetXY($posXEtiqueta, 25);
        $pdf->Cell($anchoTextoEtiqueta, 10, 'FECHA:', 0, 0, 'L');

        // Set the font and text size for the date
        $pdf->SetFont('helvetica', '', 12);

        // Draw the right-aligned rectangle
        $pdf->SetDrawColor(61, 149, 85);
        $pdf->Rect($posXFecha - 3.5, $pdf->GetY(), $anchoTextoFecha, 10, 'D'); // Adjust the position of the rectangle

        // Print the date centered within the rectangle
        $pdf->SetXY($posXFecha, $pdf->GetY() + 1);
        $pdf->Cell($anchoTextoFecha - 7, 8, $fecha, 0, 1, 'C');  // Subtract 7 units for the extra margin

        // Print the buyer's information
        $pdf->SetDrawColor(255, 131, 0);
        $pdf->SetXY(10, $pdf->GetY() + 10);

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 8, 'Datos del Comprador', 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, "Nombre: {$request->name}", 0, 1, 'L');
        $pdf->Cell(0, 5, "Contacto: {$request->contact}", 0, 1, 'L');

        // Print the table with the products and services
        $pdf->SetXY(10, $pdf->GetY() + 20);

        $columnWidths = array(10, 100, 10, 30, 40); // Column widths
        $tableHeader = array('#', 'Producto o Servicio', 'c', 'Precio Unitario', 'Total');

        // Set the header color
        $pdf->SetFillColor(255, 131, 0);
        $pdf->SetTextColor(255, 255, 255);

        // Print the header row
        $pdf->SetTextColor(255, 255, 255);
        foreach ($tableHeader as $header) {
            $pdf->Cell(array_shift($columnWidths), 8, $header, 1, 0, 'C', true);
        }
        $pdf->Ln();

        // Set the row color
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(255, 255, 255);

        // Obtener los datos del request
        $products = $request->input('product', []);
        $quantities = $request->input('quantity', []);
        $prices = $request->input('price', []);

        $total = 0;
        $extra_discount = $request->input('extra_discount', 0);

        // Print the table data
        for ($i = 0; $i < count($products); $i++) {
            // Extract values by column
            $product = $products[$i];
            $quantity = $quantities[$i];
            $price = $prices[$i];
            
            // Calculate the subtotal
            $subtotal = $quantity * $price;
            $total += $subtotal;

            // Print each row in the PDF
            $pdf->Cell(10, 12, $i + 1, 1); // # (index column)
            $pdf->Cell(100, 12, $product, 1); // Product
            $pdf->Cell(10, 12, $quantity, 1); // Quantity
            $pdf->Cell(30, 12, price_formatted($price, 2), 1); // Unit price
            $pdf->Cell(40, 12, price_formatted($subtotal, 2), 1); // Subtotal
            $pdf->Ln();
        }

        // Calculate the final total
        $final_total = $total;

        // Show the amount saved if there is a discount greater than 0
        if ($extra_discount > 0) {
            $saved_amount = $total * ($extra_discount / 100);
            $final_total = $total - $saved_amount;

            // Print the amount saved (discount applied)
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell(150, 12, 'Monto Ahorrado (' . $extra_discount . '%):', 1, 0, 'R');
            $pdf->Cell(40, 12, price_formatted($saved_amount, 2), 1, 1, 'L');
        }

        // Print the final total with the discount applied (or without discount if it doesn't apply)
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->SetFillColor(255, 131, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(150, 10, 'Total:', 1, 0, 'R');
        $pdf->Cell(40, 10, price_formatted($final_total, 2), 1, 1, 'L');

        // Add the section of thanks, contact and warranty
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->setDrawColor(61, 149, 85);
        $pdf->SetFillColor(61, 149, 85);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, $request->acknowledgments, 1, 1, 'C', true);

        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->MultiCell(0, 8, "\nPara cualquier pregunta o problema, por favor contáctanos.\n\n"
                              . "Email: contacto@canvolt.com.mx\n"
                              . "Teléfono: +52 33 3258 8070\n\n", 1, 'C');

        $fileName = next_folio() . '.pdf';
        Session::put('folio', next_folio());
        $path = storage_path('app/tickets/' . $fileName);
    
        try {
            // Save the PDF
            $pdf->Output($path, 'F');
        } catch (\Exception $e) {
            // Capturar cualquier error y devolverlo como JSON
            throw new \Exception("Error al generar el PDF: " . $e->getMessage());
        }
    }

    private function storeTicket($request, $user)
    {
        // Store the ticket
        $ticket = new Ticket();
        $ticket->folio = next_folio();
        $ticket->country_code = $request->country_code;
        $ticket->user_id = $user->id;
        $ticket->branch_office_id = auth()->user()->branchOffice->id;
        $ticket->status = 'pending';
        $ticket->type = $request->sale_type;
        $ticket->ticket_details = json_encode($request->product);
        $ticket->details = $request->details;
        $ticket->extra_discount = $request->extra_discount;
        $ticket->total_price = $this->getTotalPrice($request);
        $ticket->payment_method = $request->payment_method;
        $ticket->qr_code = next_folio();
        $ticket->save();
    }

    private function sendMail($request)
    {
        // Configuración de PHPMailer
        $mail = new PHPMailer(true);
        
        try {
            // SMTP settings
            $mail->SMTPDebug = 0; // Cambia a 0 para producción
            $mail->isSMTP();
            $mail->Host = config('mail.mailers.smtp.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.mailers.smtp.username');
            $mail->Password = config('mail.mailers.smtp.password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = config('mail.mailers.smtp.port');

            $mail->setFrom(config('mail.from.address'), 'Canvolt');
            $mail->addAddress($request->contact, $request->name);
            
            // Set the charset to UTF-8
            $mail->CharSet = PHPMailer::CHARSET_UTF8;

            // Mail settings
            $mail->isHTML(true);
            $mail->Subject = 'Detalles del Ticket de Compra';
            $mail->Body    = $this->generateTicketHtml($request);

            // Add attachment
            $fileName = Session::get('folio') . '.pdf';
            $path = storage_path('app/tickets/' . $fileName);
            $mail->addAttachment($path, $fileName);

            // Send the email
            $mail->send();
        } catch (Exception $e) {
            // Lanza una excepción para que se capture más adelante
            throw new \Exception("No se pudo enviar el correo. Error de PHPMailer: {$mail->ErrorInfo}");
        }
    }

    private function generateTicketHtml($request)
    {
        // Generar el formato HTML del ticket con los datos del formulario
        $html = "
        <h1>Ticket de Compra</h1>
        <p><strong>Nombre:</strong> {$request->name}</p>
        <p><strong>Contacto:</strong> {$request->contact}</p>
        <h2>Detalles de la Compra con el folio: " . Session::get('folio') . "</h2>
        <table border='1' cellpadding='5' cellspacing='0'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto o Servicio</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>";

        $totalGeneral = 0;
        $extra_discount = $request->input('extra_discount', 0);

        // Recorrer los productos y generar las filas de la tabla
        foreach ($request->product as $index => $product) {
            $cantidad = $request->quantity[$index];
            $precio = $request->price[$index];
            $total = $cantidad * $precio;
            $totalGeneral += $total;

            $html .= "
                <tr>
                    <td>" . ($index + 1) . "</td>
                    <td>{$product}</td>
                    <td>{$cantidad}</td>
                    <td>\${$precio}</td>
                    <td>\${$total}</td>
                </tr>";
        }

        // Calcular el descuento solo si es mayor a 0
        $totalSaved = 0;
        $totalConDescuento = $totalGeneral;

        if ($extra_discount > 0) {
            $totalSaved = $totalGeneral * ($extra_discount / 100);
            $totalConDescuento = $totalGeneral - $totalSaved;
        }

        // Agregar filas de Total General, Total Ahorrado (si hay descuento) y Total con Descuento
        $html .= "
            </tbody>
            <tfoot>
                <tr>
                    <td colspan='4' align='right'><strong>Total General:</strong></td>
                    <td>\${$totalGeneral}</td>
                </tr>";

        // Solo mostrar el total ahorrado si el descuento es mayor a 0
        if ($extra_discount > 0) {
            $html .= "
                <tr>
                    <td colspan='4' align='right'><strong>Total Ahorrado ({$extra_discount}%):</strong></td>
                    <td>\${$totalSaved}</td>
                </tr>
                <tr>
                    <td colspan='4' align='right'><strong>Total con Descuento:</strong></td>
                    <td>\${$totalConDescuento}</td>
                </tr>";
        }

        // Cerrar la tabla y agregar el mensaje de agradecimiento
        $html .= "
            </tfoot>
        </table>
        <p><strong>Mensaje de Agradecimiento:</strong> {$request->acknowledgments}</p>";

        return $html;
    }
    
    private function getTotalPrice($request)
    {
        $products = $request->input('product', []);
        $quantities = $request->input('quantity', []);
        $prices = $request->input('price', []);

        $total = 0;
        $extra_discount = $request->input('extra_discount', 0);

        // Calculate the total without applying the discount
        foreach ($products as $index => $product) {
            $total += $quantities[$index] * $prices[$index];
        }

        // Apply the additional discount if it is greater than 0
        if ($extra_discount > 0) {
            $total = $total - ($total * ($extra_discount / 100));
        }

        // Return the total with the discount applied (if applies)
        return $total;
    }
}
