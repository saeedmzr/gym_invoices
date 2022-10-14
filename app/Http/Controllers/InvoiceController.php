<?php

namespace App\Http\Controllers;

use App\Http\Resources\Invoice\InvoiceResource;
use App\Repositories\Invoice\InvoiceRepository;

class InvoiceController extends Controller
{
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function userInvoices()
    {
        $invoices = $this->invoiceRepository->userInvoices(auth()->user());
        return InvoiceResource::collection($invoices);
    }

}
