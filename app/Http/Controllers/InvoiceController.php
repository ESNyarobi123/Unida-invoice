<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function builder(Request $request): View
    {
        $history = Invoice::orderBy('created_at', 'desc')->get()->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'invoiceNumber' => $invoice->invoice_number,
                'issueDate' => $invoice->issue_date->format('Y-m-d'),
                'supportLine' => $invoice->support_line,
                'clientName' => $invoice->client_name,
                'clientCompany' => $invoice->client_company,
                'clientEmail' => $invoice->client_email,
                'clientLocation' => $invoice->client_location,
                'clientMobile' => $invoice->client_mobile,
                'service' => $invoice->service,
                'website' => $invoice->website,
                'currency' => $invoice->currency,
                'budget' => $invoice->budget,
                'created_by' => $invoice->created_by,
                'saved_at' => $invoice->created_at->toDateTimeString(),
            ];
        });

        $today = now()->timezone('Africa/Dar_es_Salaam');
        
        // Generate unique invoice number: UNIDA-YYYY-XXX (where XXX is sequential for the year)
        $year = $today->format('Y');
        $lastInvoice = Invoice::where('invoice_number', 'like', "UNIDA-{$year}-%")
            ->orderBy('invoice_number', 'desc')
            ->first();
        
        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_number, -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }
        
        $defaultInvoice = "UNIDA-{$year}-{$nextNumber}";

        return view('invoice', [
            'history' => $history,
            'today' => $today,
            'defaultInvoice' => $defaultInvoice,
            'user' => $request->session()->get('user'),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'invoiceNumber' => ['required', 'string', 'max:50'],
            'issueDate' => ['required', 'date'],
            'supportLine' => ['nullable', 'string', 'max:50'],
            'clientName' => ['required', 'string', 'max:120'],
            'clientCompany' => ['nullable', 'string', 'max:120'],
            'clientEmail' => ['nullable', 'email', 'max:120'],
            'clientLocation' => ['nullable', 'string', 'max:200'],
            'clientMobile' => ['nullable', 'string', 'max:60'],
            'service' => ['nullable', 'string', 'max:2000'],
            'website' => ['nullable', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:10'],
            'budget' => ['required', 'numeric', 'min:0'],
        ]);

        // Check if invoice number already exists
        if (Invoice::where('invoice_number', $data['invoiceNumber'])->exists()) {
            return response()->json([
                'message' => 'Invoice number already exists',
                'error' => true,
            ], 422);
        }

        $invoice = Invoice::create([
            'invoice_number' => $data['invoiceNumber'],
            'issue_date' => $data['issueDate'],
            'support_line' => $data['supportLine'] ?? null,
            'client_name' => $data['clientName'],
            'client_company' => $data['clientCompany'] ?? null,
            'client_email' => $data['clientEmail'] ?? null,
            'client_location' => $data['clientLocation'] ?? null,
            'client_mobile' => $data['clientMobile'] ?? null,
            'service' => $data['service'] ?? null,
            'website' => $data['website'] ?? null,
            'currency' => $data['currency'],
            'budget' => $data['budget'],
            'created_by' => $request->session()->get('user')['email'] ?? 'system',
        ]);

        $history = Invoice::orderBy('created_at', 'desc')->get()->map(function ($inv) {
            return [
                'id' => $inv->id,
                'invoiceNumber' => $inv->invoice_number,
                'issueDate' => $inv->issue_date->format('Y-m-d'),
                'supportLine' => $inv->support_line,
                'clientName' => $inv->client_name,
                'clientCompany' => $inv->client_company,
                'clientEmail' => $inv->client_email,
                'clientLocation' => $inv->client_location,
                'clientMobile' => $inv->client_mobile,
                'service' => $inv->service,
                'website' => $inv->website,
                'currency' => $inv->currency,
                'budget' => $inv->budget,
                'created_by' => $inv->created_by,
                'saved_at' => $inv->created_at->toDateTimeString(),
            ];
        });

        return response()->json([
            'message' => 'Invoice saved successfully',
            'invoice' => $invoice,
            'history' => $history,
        ]);
    }
}

