<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Stock;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(): View
    {
        return view('stock.index');
    }

    public function create(): View
    {
        $validator = $this->validationService->generateValidation(StockRequest::class, '#form-create-stock');

        return view('stock.create', compact(['validator']));
    }

    public function store(StockRequest $request)
    {

    }

    public function edit(Stock $stock): View
    {
        $validator = $this->validationService->generateValidation(StockRequest::class, '#form-edit-stock');

        return view('stock.edit', compact(['stock', 'validator']));
    }

    public function update(StockRequest $request, Stock $stock)
    {

    }

    public function destroy()
    {

    }
}
