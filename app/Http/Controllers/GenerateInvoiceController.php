<?php

namespace App\Http\Controllers;

use App\Services\GenerateInvoiceServices;

class GenerateInvoiceController extends Controller
{
    public function __construct(
        private readonly GenerateInvoiceServices $service
    )
    {}

    /**
     * @throws \Exception
     */
    public function generateInvoice(): void
    {
        $this->service->generateInvoice();
    }
}
