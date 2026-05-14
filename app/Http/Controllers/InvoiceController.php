<?php
// app/Http/Controllers/InvoiceController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    // ── Download Invoice (Customer) ────────────────────────────
    // Route: GET /orders/{orderNumber}/invoice
    public function download($orderNumber)
    {
        $order = Order::with('items', 'user')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return $this->generatePdf($order);
    }

    // ── Download Invoice (Admin) ───────────────────────────────
    // Route: GET /admin/orders/{id}/invoice
    public function adminDownload(Order $order)
    {
        $order->load('items', 'user');
        return $this->generatePdf($order);
    }

    // ── Generate PDF via Blade view ────────────────────────────
    private function generatePdf(Order $order)
    {
        $html = view('invoice.pdf', compact('order'))->render();

        // Use DomPDF if available, else return HTML
       if (class_exists(Pdf::class)) {
             $pdf = Pdf::loadHTML($html)
                ->setPaper('a4', 'portrait');
            return $pdf->download('invoice-' . $order->order_number . '.pdf');
        }

        // Fallback: return printable HTML
        return response($html)->header('Content-Type', 'text/html');
    }
}