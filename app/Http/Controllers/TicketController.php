<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            // Generar el ticket
            $this->generateTicket($request);

            // Enviar correo
            $this->sendMail($request);

            // Si se ha enviado correctamente, guardar el ticket en la base de datos
            $this->saveTicket($request);

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

    private function saveTicket($request)
    {
        $user = evaluateUser($request->contact);

        // Crear un nuevo ticket en la base de datos
        $ticket = new Ticket();
        $ticket->folio = next_folio();
        $ticket->country_code = 'MX';
        $ticket->user_id = ;
        $ticket->name = $request->name;
        $ticket->contact = $request->contact;
        $ticket->acknowledgments = $request->acknowledgments;
        $ticket->save();

        // Guardar los datos del ticket en la tabla tickets
        foreach ($request->product as $index => $product) {
            $ticket->products()->create([
                'product' => $product,
                'quantity' => $request->quantity[$index],
                'price' => $request->price[$index]
            ]);
        }
    }

    private function evaluateUser($contact)
    {
        $user = User::where(function ($query) use ($contact) {
            $query->whereJsonContains('contact->email', $contact)
                  ->orWhereJsonContains('contact->phone', $contact);
        })->first();
        
        return $user;
    }

    private function generateTicket($request)
    {
        /**
         * PDF dimensions width and height
         * width: 595px
         * height: 842px
         */

        try {
            $pdf = new TCPDF();
            $pdf->AddPage();

            // PDF format
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFillColor(23, 23, 23);
            $pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'F');
            $pdf->Image(public_path('images/canvolt-water-mark.png'), 25, 50, 160, 0, 'PNG');
            $pdf->Image(public_path('images/logo.png'), 5, 6, 50, 0, 'PNG');
            
            // Folio and date information
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

            // Obtener la fecha en formato español
            $fecha = current_date_spanish();

            // Obtener el ancho del texto de la fecha
            $anchoTextoFecha = $pdf->GetStringWidth($fecha) + 14; // Añadir un margen extra de 7 unidades

            // Calcular la posición en X para alinear a la derecha
            $marginRight = 1.5; // Margen derecho del PDF
            $posXFecha = $pdf->getPageWidth() - $anchoTextoFecha - $marginRight; // Posición de la fecha alineada a la derecha

            // Calcular la posición del texto "FECHA:" relativa al rectángulo de la fecha
            $anchoTextoEtiqueta = $pdf->GetStringWidth('FECHA:') + 5; // Ancho del texto "FECHA:" + margen de 2 unidades
            $posXEtiqueta = $posXFecha - $anchoTextoEtiqueta - 2; // Colocar "FECHA:" justo a la izquierda del rectángulo de la fecha

            // Establecer la posición para "FECHA:" en función de la posición calculada
            $pdf->SetXY($posXEtiqueta, 25);
            $pdf->Cell($anchoTextoEtiqueta, 10, 'FECHA:', 0, 0, 'L');

            // Establecer la fuente y el tamaño del texto para la fecha
            $pdf->SetFont('helvetica', '', 12);

            // Dibujar el rectángulo alineado a la derecha
            $pdf->SetDrawColor(61, 149, 85);
            $pdf->Rect($posXFecha - 3.5, $pdf->GetY(), $anchoTextoFecha, 10, 'D'); // Ajustar posición del rectángulo

            // Imprimir la fecha centrada dentro del rectángulo
            $pdf->SetXY($posXFecha, $pdf->GetY() + 1);
            $pdf->Cell($anchoTextoFecha - 7, 8, $fecha, 0, 1, 'C');  // Restamos 7 unidades para el margen extra

            // Print the buyer's information
            $pdf->SetDrawColor(255, 131, 0);
            $pdf->SetXY(10, $pdf->GetY() + 15);

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

            // Print the table data
            $products = $request->input('product', []);
            $quantities = $request->input('quantity', []);
            $prices = $request->input('price', []);

            $total = 0;

            // Print the table data
            for ($i = 0; $i < count($products); $i++) {
                // Extract each value from each column
                $product = $products[$i];
                $quantity = $quantities[$i];
                $price = $prices[$i];
                
                // Calculate the subtotal
                $subtotal = $quantity * $price;
                $total += $subtotal;

                // Imprimir los datos en el PDF
                $pdf->Cell(10, 12, $i + 1, 1); // # (index column)
                $pdf->Cell(100, 12, $product, 1); // Product or service
                $pdf->Cell(10, 12, $quantity, 1); // Quantity
                $pdf->Cell(30, 12, price_formatted($price, 2), 1); // Unit price
                $pdf->Cell(40, 12, price_formatted($subtotal, 2), 1); // Total
                $pdf->Ln();
            }

            // Add the last row with the total
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->SetFillColor(255, 131, 0);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(150, 10, 'Total: ', 1, 0, 'R');
            $pdf->Cell(40, 10, price_formatted($total), 1, 1, 'L');

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
            $path = storage_path('app/public/tickets/' . $fileName);
    
            $pdf->Output($path, 'F');  // Guardar el PDF
        } catch (\Exception $e) {
            // Capturar cualquier error y devolverlo como JSON
            throw new \Exception("Error al generar el PDF: " . $e->getMessage());
        }
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
            $fileName = next_folio() . '.pdf';
            $path = storage_path('app/public/tickets/' . $fileName);
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
        <h2>Detalles de la Compra con el folio: " . next_folio() . "</h2>
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
        foreach ($request->product as $index => $product) {
            $cantidad = $request->quantity[$index];
            $precio = $request->price[$index];
            $total = $cantidad * $precio;
            $totalGeneral += $total;

            $html .= "
                <tr>
                    <td>".($index + 1)."</td>
                    <td>{$product}</td>
                    <td>{$cantidad}</td>
                    <td>\${$precio}</td>
                    <td>\${$total}</td>
                </tr>";
        }

        $html .= "
            </tbody>
            <tfoot>
                <tr>
                    <td colspan='4' align='right'><strong>Total General:</strong></td>
                    <td>\${$totalGeneral}</td>
                </tr>
            </tfoot>
        </table>
        <p><strong>Mensaje de Agradecimiento:</strong> {$request->acknowledgments}</p>";

        return $html;
    }
}
