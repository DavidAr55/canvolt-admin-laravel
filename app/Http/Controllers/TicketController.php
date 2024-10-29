<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Product;
use App\Models\Inventory;
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

            // Store the purchase
            $this->checkTicketType($request); // Se maneja adecuadamente ahora

            // Send email
            $this->sendMail($request);

            // Clear the session
            Session::forget('fileName');
            Session::forget('contact');
            Session::forget('method');

            return response()->json([
                'message' => 'Ticket enviado correctamente',
                'data' => $request->all()
            ]);
        } catch (\Exception $e) {
            // Log el error completo para verificar qué sucede
            Log::error("Error en TicketController@store: " . $e->getMessage());

            // Responder con un JSON adecuado para mostrar el error en el frontend
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
        $pdf->SetXY(10, $pdf->GetY() + 20);

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

        // Get the data from the request
        $products = $request->input('products', []);
        $quantities = $request->input('quantities', []);
        $prices = $request->input('prices', []);

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
        // $path = storage_path('tickets/' . $fileName);
        $path = public_path('storage/tickets/' . $fileName);
    
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
        $ticket->folio = Session::get('folio');
        $ticket->country_code = $request->country_code;
        $ticket->user_id = $user->id;
        $ticket->branch_office_id = auth()->user()->branchOffice->id;
        $ticket->status = 'pending';
        $ticket->type = $request->sale_type;

        // Build the array with the ticket details in the required format
        $ticketDetails = [];
        foreach ($request->products as $index => $item) {
            // Check if it's a product or service
            if ($request->types[$index] === 'product') {
                // Add as product
                $ticketDetails[] = [
                    'product' => $item,
                    'quantity' => intval($request->quantities[$index]),
                    'unit_price' => number_format($request->prices[$index], 2),
                ];
            } elseif ($request->types[$index] === 'service') {
                // Add as service
                $ticketDetails[] = [
                    'service' => $item,
                    'quantity' => intval($request->quantities[$index]),
                    'unit_price' => number_format($request->prices[$index], 2),
                ];
            }
        }

        // Assign the formatted array as JSON to the ticket_details column
        $ticket->ticket_details = json_encode($ticketDetails);

        // Assign other ticket fields
        $ticket->details = $request->details;
        $ticket->extra_discount = $request->extra_discount;
        $ticket->total_price = $this->getTotalPrice($request);
        $ticket->payment_method = $request->payment_method;
        $ticket->qr_code = Session::get('folio');
        $ticket->save();

        // Check if it was saved correctly, otherwise throw an exception
        if (!$ticket->save()) {
            throw new \Exception("Error al guardar el ticket");
        }
    }

    private function checkTicketType($request)
    {
        // Verificar si el ticket es una venta, si no lo es, continuar sin hacer nada
        if($request->ticket === 'sale') {
            // Recorrer los productos enviados en el request
            foreach ($request->products as $index => $product) {
                try {
                    // Separar el string de producto en "brand" y "name"
                    $productParts = explode(' - ', $product);
                    $brand = trim($productParts[0]);
                    $name = trim($productParts[1]);

                    // Buscar el producto en la base de datos por brand y name
                    $productModel = Product::where('brand', $brand)
                                        ->where('name', $name)
                                        ->first();

                    if (!$productModel) {
                        // Si el producto no se encuentra, lanzar una excepción
                        throw new \Exception("Producto no encontrado: {$brand} - {$name}");
                    }

                    // Obtener el inventario del producto
                    $inventory = Inventory::where('product_id', $productModel->id)->first();

                    if (!$inventory) {
                        // Si no se encuentra el inventario, lanzar una excepción
                        throw new \Exception("Inventario no encontrado para el producto: {$brand} - {$name}");
                    }

                    // Verificar si la cantidad está disponible en el array `quantities`
                    if (!isset($request->quantities[$index])) {
                        throw new \Exception("Cantidad no encontrada para el producto: {$brand} - {$name}");
                    }

                    // Restar la cantidad correspondiente del stock
                    $inventory->stock -= $request->quantities[$index];
                    $inventory->save();
                } catch (\Exception $e) {
                    // Loggear el error y lanzar la excepción para ser manejada por el controlador
                    Log::error("Error en checkTicketType: " . $e->getMessage());
                    throw $e;  // Re-lanzar la excepción para que sea atrapada en el controlador
                }
            }
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
            $fileName = Session::get('folio') . '.pdf';
            $path = public_path('storage/tickets/' . $fileName);
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
        // Obtener el folio de la sesión
        $folio = Session::get('folio');
        
        // Definir colores de la plantilla
        $darkGray = "#171717";
        $lightGray = "#3D3D3D";
        $orange = "#FF8300";
        $green = "#3D9555";
        $white = "#FFFFFF";

        // Generar el formato HTML del ticket con los datos del formulario
        $html = "
        <div style='background-color: {$white}; padding: 0; margin: 0; font-family: Helvetica, Arial, sans-serif; color: {$darkGray};'>
            <table style='max-width: 840px; margin: 0 auto;' cellpadding='0' cellspacing='0' width='100%' height='100%'>
                <tbody>
                    <!-- Encabezado con logo -->
                    <tr>
                        <td colspan='3' style='background-color: {$darkGray}; padding: 20px; text-align: center;'>
                            <a href='https://canvolt.com.mx' target='_blank'>
                                <img src='https://sistema.canvolt.com.mx/public/images/logo-4-canvolt.png' alt='Logo Canvolt' style='width: 220px;'>
                            </a>
                        </td>
                    </tr>

                    <!-- Espaciado para la cabecera -->
                    <tr>
                        <td style='height: 20px; background-color: {$orange};'></td>
                        <td style='background-color: {$white}; border: 1px solid {$lightGray}; padding: 24px;'>
                            
                            <!-- Saludo inicial -->
                            <h2 style='margin: 0; color: {$darkGray};'>Hola, {$request->name}</h2>
                            <p style='color: #6c757d;'>Gracias por comprar con nosotros en Canvolt.</p>

                            <!-- Detalles de la compra -->
                            <table style='width: 100%; font-size: 90%; margin-bottom: 20px;'>
                                <tbody>
                                    <tr>
                                        <th style='text-align: right; padding: 4px;'>Folio:</th>
                                        <td style='padding-left: 10px;'>{$folio}</td>
                                    </tr>
                                    <tr>
                                        <th style='text-align: right; padding: 4px;'>Fecha:</th>
                                        <td style='padding-left: 10px;'>".current_date_spanish()."</td>
                                    </tr>
                                    <tr>
                                        <th style='text-align: right; padding: 4px;'>Importe:</th>
                                        <td style='padding-left: 10px;'>".price_formatted($this->getTotalPrice($request), 2)."</td>
                                    </tr>
                                    <tr>
                                        <th style='text-align: right; padding: 4px;'>Metodo de Pago:</th>
                                        <td style='padding-left: 10px;'>".payment_method_spanish($request->payment_method)."</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Listado de productos -->
                            <table cellpadding='0' cellspacing='0' width='100%' style='background-color: #f5f5f5; font-size: 90%;'>
                                <thead>
                                    <tr style='background-color: {$lightGray}; color: {$white};'>
                                        <th style='padding: 10px;'>Producto</th>
                                        <th style='padding: 10px;'>Detalles</th>
                                        <th style='padding: 10px;'>Cantidad</th>
                                        <th style='padding: 10px;'>Precio Unitario</th>
                                        <th style='padding: 10px;'>Total</th>
                                    </tr>
                                </thead>
                                <tbody>";

                                // Inicializar el total general
                                $totalGeneral = 0;

                                // Recorrer los productos y generar las filas de la tabla incluyendo las imágenes
                                foreach ($request->products as $index => $product) {
                                    $cantidad = $request->quantities[$index];
                                    $precio = $request->prices[$index];
                                    $total = $cantidad * $precio;
                                    $totalGeneral += $total;
                                    // Uncomment this line on production
                                    # $img = public_path('storage/' . $request->product_imgs[$index]);

                                    // This option only works on product "B9kvtOSINOxBa8Hwd7rKyctoGfZPhqouwvVuRcMt.png" or "Xiaomi - T2S Pro"
                                    $img = "https://assets.canvolt.mx/assets-canvolt/" . $request->product_imgs[$index];

                                    $html .= "
                                    <tr>
                                        <td style='padding: 14px; text-align: left;'><img src='{$img}' alt='{$product}' style='width: 70px;'></td>
                                        <td style='padding: 14px; text-align: left;'>{$product}</td>
                                        <td style='padding: 14px; text-align: center;'>{$cantidad}</td>
                                        <td style='padding: 14px; text-align: center;'>".price_formatted($precio, 2)."</td>
                                        <td style='padding: 14px; text-align: center;'>".price_formatted($total, 2)."</td>
                                    </tr>";
                                }

                                // Descuento adicional
                                $extra_discount = $request->input('extra_discount', 0);
                                $totalSaved = 0;
                                $totalConDescuento = $totalGeneral;

                                if ($extra_discount > 0) {
                                    $totalSaved = $totalGeneral * ($extra_discount / 100);
                                    $totalConDescuento = $totalGeneral - $totalSaved;
                                }

                                $html .= "
                                </tbody>
                            </table>

                            <!-- Resumen de la compra -->
                            <table align='center' style='margin-top: 20px; font-size: 90%; width: 100%;'>
                                <tr>
                                    <td style='text-align: right;'>Subtotal:</td>
                                    <td style='padding-left: 20px; text-align: right;'>".price_formatted($totalGeneral, 2)."</td>
                                </tr>";

                            // Mostrar el descuento si es aplicable
                            if ($extra_discount > 0) {
                                $html .= "
                                <tr>
                                    <td style='text-align: right;'>Descuento ({$extra_discount}%):</td>
                                    <td style='padding-left: 20px; text-align: right; color: {$green};'>".price_formatted($totalSaved, 2)."</td>
                                </tr>";
                            }

                            $html .= "
                                <tr>
                                    <td style='text-align: right;'><strong>Total:</strong></td>
                                    <td style='padding-left: 20px; text-align: right;'><strong>".price_formatted($totalConDescuento, 2)."</strong></td>
                                </tr>
                            </table>

                            <!-- Mensaje de agradecimiento -->
                            <p style='margin-top: 20px;'>Si tienes alguna pregunta o necesitas asistencia, no dudes en ponerte en contacto con nosotros a través de: 
                            <a href='mailto:contacto@canvolt.com.mx' style='color: {$orange}; text-decoration: none;'>contacto@canvolt.com.mx</a></p>
                            
                            <p>Gracias nuevamente por elegirnos.</p>
                            <p>Saludos cordiales,<br>El equipo de Canvolt</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td colspan='3' style='background-color: #dcdcdc; padding: 24px 14px; text-align: center;'>
                            <p style='margin: 0; color: #212529; font-size: 12px;'>© 2024 Canvolt. Todos los derechos reservados.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>";

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
