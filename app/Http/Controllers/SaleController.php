<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Sale;
use App\Services\ValidationService;
use Illuminate\View\View;

class SaleController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(): View
    {
        return view('sale.index');
    }

    public function create(): View
    {
        $validator = $this->validationService->generateValidation(SaleRequest::class, '#form-create-sale');

        return view('sale.create', compact(['validator']));
    }

    public function store(SaleRequest $request)
    {

    }

    public function edit(Sale $sale): View
    {
        $validator = $this->validationService->generateValidation(SaleRequest::class, '#form-edit-sale');

        return view('sale.edit', compact(['sale', 'validator']));
    }

    public function update(SaleRequest $request, Sale $sale)
    {

    }

    public function destroy()
    {

    }
}
