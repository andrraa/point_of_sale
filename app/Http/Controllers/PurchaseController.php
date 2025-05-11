<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Services\ValidationService;
use Illuminate\View\View;

class PurchaseController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(): View
    {
        return view('purchase.index');
    }

    public function create(): View
    {
        $validator = $this->validationService->generateValidation(PurchaseRequest::class, '#form-create-purchase');

        return view('purchase.create', compact(['validator']));
    }

    public function store(PurchaseRequest $request)
    {

    }

    public function edit(Purchase $purchase): View
    {
        $validator = $this->validationService->generateValidation(PurchaseRequest::class, '#form-edit-purchase');

        return view('purchase.edit', compact(['purchase', 'validator']));
    }

    public function update(PurchaseRequest $request, Purchase $purchase)
    {

    }

    public function destroy()
    {

    }
}
