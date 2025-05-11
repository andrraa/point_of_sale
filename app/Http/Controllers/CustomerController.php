<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Services\ValidationService;
use Illuminate\View\View;

class CustomerController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(): View
    {
        return view('customer.index');
    }

    public function create(): View
    {
        $validator = $this->validationService->generateValidation(CustomerRequest::class, '#form-create-customer');

        return view('customer.create', compact(['validator']));
    }

    public function store(CustomerRequest $request)
    {

    }

    public function edit(): View
    {
        $validator = $this->validationService->generateValidation(CustomerRequest::class, '#form-edit-customer');

        return view('customer.edit', compact(['validator']));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {

    }

    public function destroy(Customer $customer)
    {

    }
}
