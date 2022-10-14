<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Invoice\AdminInvoiceResource;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Http\Resources\SimpleResource;
use App\Models\Invoice;
use App\Repositories\Invoice\InvoiceRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InvoiceController extends Controller
{
    private InvoiceRepository $InvoiceRepository;

    public function __construct(InvoiceRepository $InvoiceRepository)
    {
        $this->InvoiceRepository = $InvoiceRepository;
    }

    public function index(): AnonymousResourceCollection
    {
        $invoices = $this->InvoiceRepository->all();
        return AdminInvoiceResource::collection($invoices);
    }

    public function show(Invoice $invoice): AdminInvoiceResource
    {
        return new AdminInvoiceResource($invoice);
    }



}
