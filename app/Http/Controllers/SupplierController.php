<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use App\Services\ValidationService;
use Illuminate\View\View;

class SupplierController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(): View
    {
        return view('supplier.index');
    }

    public function create(): View
    {
        $validator = $this->validationService->generateValidation(SupplierRequest::class, '#form-create-supplier');

        return view('supplier.create', compact(['validator']));
    }

    public function store(SupplierRequest $request)
    {

    }

    public function edit(Supplier $supplier): View
    {
        $validator = $this->validationService->generateValidation(SupplierRequest::class, '#form-edit-supplier');

        return view('supplier.edit', compact(['supplier', 'validator']));
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {

    }

    public function destroy()
    {

    }
}
