<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use TCPDF;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class CreatePickupOrderController extends Controller
{
    /**
     * Create a PDF for the pickup order with a centered QR code.
     * 
     * @param array $purchaseInformation
     * @return string The path to the generated PDF.
     */
    public function createPickupOrder()
    {
        // Path where the PDF will be saved
        $pdfPath = public_path('storage/pickup_orders');
        if (!file_exists($pdfPath)) {
            mkdir($pdfPath, 0777, true);
        }

        // Create TCPDF instance
        $pdf = new TCPDF();

        // Set document information
        $pdf->SetCreator('Your Application');
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Pickup Order');
        $pdf->SetSubject('Order Details');
        $pdf->SetKeywords('PDF, Pickup, QR Code, Order');

        // Add a page
        $pdf->AddPage();

        // Set default font and size
        $pdf->SetFont('helvetica', '', 12);

        // Add content to the PDF (like purchase information)
        $pdf->Cell(0, 10, 'Pickup Order Information', 0, 1, 'C');
        $pdf->Ln(10); // Line break

        // Example: add purchase information to the PDF
        $pdf->MultiCell(0, 10, "Order ID: " . 'order_id', 0, 'C');
        $pdf->MultiCell(0, 10, "Customer Name: " . 'customer_name', 0, 'C');
        $pdf->MultiCell(0, 10, "Pickup Date: " . 'pickup_date', 0, 'C');
        $pdf->Ln(10); // Line break

        // Generate QR code using SVG backend
        $qrContent = 'QR Content Example';  // The content to encode in the QR

        // Set up BaconQrCode renderer with SVG backend
        $renderer = new ImageRenderer(
            new RendererStyle(200), // QR code size
            new SvgImageBackEnd() // Use SVG backend
        );
        $writer = new Writer($renderer);

        // Save the QR code to a temporary file in SVG format
        $qrPath = public_path('storage/pickup_orders/temp_qr.svg');
        $writer->writeFile($qrContent, $qrPath);

        // Add the QR code to the PDF (centrado)
        $pdf->ImageSVG($file=$qrPath, $x=$pdf->GetX(), $y=$pdf->GetY(), $w=50, $h=50);

        // Remove the temporary QR code image
        unlink($qrPath);

        // Define the PDF filename
        $fileName = 'pickup_order_' . 'order_id' . '.pdf';

        // Save the PDF in storage
        $pdf->Output($pdfPath . '/' . $fileName, 'F');

        // Return the path to the PDF
        return $pdfPath . '/' . $fileName;
    }
}
