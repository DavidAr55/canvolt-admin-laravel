<?php

namespace App\Http\Controllers\Api\V1;

use TCPDF;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\Controller;
use App\Models\PickupOrder;
class CreatePickupOrderController extends Controller
{
    /**
     * Create a styled PDF for the pickup order with a centered QR code.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPickupOrder(Request $request)
    {
        $qr_code = $request->qr_code;
        $pickupOrder = $this->getPickupOrder($qr_code);

        // Path donde se guardará el PDF
        $pdfPath = public_path('storage/pickup_orders');
        if (!file_exists($pdfPath)) {
            mkdir($pdfPath, 0777, true);
        }

        // Crear instancia de TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();

        // Configurar color de fondo y agregar el logo/marca de agua
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(23, 23, 23);
        $pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'F');
        $pdf->Image(public_path('images/logo.png'), 5, 6, 50, 0, 'PNG');

        // Información de la orden
        $pdf->setTextColor(61, 149, 85);
        $pdf->SetFont('helvetica', 'B', 36);
        $pdf->Cell(0, 70, 'ORDEN PARA RECOGER', 0, 1, 'C');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', '', 14);

        // Establecer el color del texto
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetX(x: 50);
        $pdf->MultiCell(150, 10, "ID de Orden: " . $qr_code, 0, 'L');
        $pdf->SetX(50);
        $pdf->MultiCell(150, 10, "Cliente: " . $pickupOrder->user->name . " " . $pickupOrder->user->last_name, 0, 'L');
        $pdf->SetX(50);
        $pdf->MultiCell(150, 10, "Fecha para Recoger: " . current_date_spanish(), 0, 'L');

        // Generar el contenido para el QR y su ubicación
        $qrContent = config('app.url') . '/api/v1/get-pickup-order/' . $qr_code;
        $renderer = new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );
        $writer = new \BaconQrCode\Writer($renderer);

        // Crear el código QR temporalmente
        $qrPath = $pdfPath . '/temp_qr.svg';
        $writer->writeFile($qrContent, $qrPath);

        // Agregar el código QR al PDF
        $qrX = ($pdf->getPageWidth() - 100) / 2;
        $qrY = $pdf->GetY() + 20;
        $padding = 5;
        $pdf->SetFillColor(255, 255, 255);
        $pdf->RoundedRect($qrX - $padding / 2, $qrY - $padding / 2, 100 + $padding, 100 + $padding, 5, '1111', 'F');
        $pdf->ImageSVG($file = $qrPath, $x = $qrX, $y = $qrY, $w = 100, $h = 100);

        // Guardar el PDF
        $fileName = 'pickup_order_' . $qr_code . '.pdf';
        $pdfFilePath = $pdfPath . '/' . $fileName;
        $pdf->Output($pdfFilePath, 'F');

        // Enviar el PDF por correo usando PHPMailer
        $this->sendEmail($pdfFilePath, $pickupOrder);

        // Eliminar el archivo PDF temporal después del envío
        unlink($pdfFilePath);
    }

    private function getPickupOrder($qr_code)
    {
        $pickupOrder = PickupOrder::where('qr_code', $qr_code)->first();
        return $pickupOrder;
    }

    /**
     * Send email with PDF attachment
     * 
     * @param string $recipientEmail
     * @param string $pdfFilePath
     * @param \App\Models\PickupOrder $pickupOrder
     * @return void
     */
    private function sendEmail($pdfPath, $pickupOrder)
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
            $mail->addAddress($pickupOrder->user->email, $pickupOrder->user->name . ' ' . $pickupOrder->user->last_name);
            
            // Set the charset to UTF-8
            $mail->CharSet = PHPMailer::CHARSET_UTF8;

            // Mail settings
            $mail->isHTML(true);
            $mail->Subject = 'Detalles de la Orden para Recoger';
            $mail->Body    = $this->generatePickupOrderHtml($pickupOrder);

            // Add attachment
            $fileName = 'pickup_order_' . $pickupOrder->qr_code . '.pdf';
            $path = public_path('storage/pickup_orders/' . $fileName);
            $mail->addAttachment($path, $fileName);

            // Send the email
            $mail->send();
        } catch (Exception $e) {
            // Lanza una excepción para que se capture más adelante
            throw new \Exception("No se pudo enviar el correo. Error de PHPMailer: {$mail->ErrorInfo}");
        }
    }

    private function generatePickupOrderHtml($pickupOrder)
    {
        // Obtener el folio de la sesión
        $qr_code = $pickupOrder->qr_code;

        // Decodificar JSON de los productos
        $products = json_decode($pickupOrder->items, true);

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
                            <a href='https://canvolt.mx' target='_blank'>
                                <img src='https://assets.canvolt.mx/logo-4-canvolt.png' alt='Logo Canvolt' style='width: 220px;'>
                            </a>
                        </td>
                    </tr>

                    <!-- Espaciado para la cabecera -->
                    <tr>
                        <td style='height: 20px; background-color: {$orange};'></td>
                        <td style='background-color: {$white}; border: 1px solid {$lightGray}; padding: 24px;'>
                            
                            <!-- Saludo inicial -->
                            <h2 style='margin: 0; color: {$darkGray};'>Hola, {$pickupOrder->user->name} {$pickupOrder->user->last_name}</h2>
                            <p style='color: #6c757d;'>Gracias por comprar con nosotros en Canvolt.</p>

                            <!-- Detalles de la compra -->
                            <table style='width: 100%; font-size: 90%; margin-bottom: 20px;'>
                                <tbody>
                                    <tr>
                                        <th style='text-align: right; padding: 4px;'>Folio:</th>
                                        <td style='padding-left: 10px;'>{$qr_code}</td>
                                    </tr>
                                    <tr>
                                        <th style='text-align: right; padding: 4px;'>Fecha:</th>
                                        <td style='padding-left: 10px;'>".current_date_spanish()."</td>
                                    </tr>
                                    <tr>
                                        <th style='text-align: right; padding: 4px;'>Importe:</th>
                                        <td style='padding-left: 10px;'>".price_formatted($this->getTotalPrice($pickupOrder), 2)."</td>
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
                                foreach ($products as $product) {
                                    $cantidad = $product['quantity'];
                                    $precio = $product['price'];
                                    $total = $cantidad * $precio;
                                    $totalGeneral += $total;
                                    
                                    $img = "https://assets.canvolt.mx/" . $product['photo_main'];

                                    $html .= "
                                    <tr>
                                        <td style='padding: 14px; text-align: left;'><img src='{$img}' alt='{$product['name']}' style='width: 70px;'></td>
                                        <td style='padding: 14px; text-align: left;'>{$product['name']}</td>
                                        <td style='padding: 14px; text-align: center;'>{$cantidad}</td>
                                        <td style='padding: 14px; text-align: center;'>".price_formatted($precio, 2)."</td>
                                        <td style='padding: 14px; text-align: center;'>".price_formatted($total, 2)."</td>
                                    </tr>";
                                }

                                $html .= "
                                </tbody>
                            </table>

                            <!-- Resumen de la compra -->
                            <table align='center' style='margin-top: 20px; font-size: 90%; width: 100%;'>
                                <tr>
                                    <td style='text-align: right;'>Subtotal:</td>
                                    <td style='padding-left: 20px; text-align: right;'>".price_formatted($totalGeneral, 2)."</td>
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

    private function getTotalPrice($pickupOrder)
    {
        $products = json_decode($pickupOrder->items, true);

        $total = 0;

        // Calcular el total sin aplicar descuento
        foreach ($products as $product) {
            $total += $product['quantity'] * $product['price'];
        }

        return $total;
    }
}
