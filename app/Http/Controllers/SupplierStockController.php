<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStockRequest;
use App\Models\SupplierStock;
use App\Services\ValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SupplierStockController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $suppliers = SupplierStock::query()
                ->select([
                    'ss_id',
                    'ss_name',
                    'ss_phone',
                    'ss_address'
                ]);

            return DataTables::of($suppliers)
                ->addIndexColumn()
                ->escapeColumns()
                ->addColumn('actions', fn($supplier) => [
                    'edit' => route('supplier-stock.edit', $supplier->ss_id),
                    'detail' => route('supplier-stock.show', $supplier->ss_id),
                    'delete' => route('supplier-stock.destroy', $supplier->ss_id)
                ])
                ->toJson();
        }

        return view('supplier-stock.index');
    }

    public function create(): View
    {
        $validator = $this->validationService
            ->generateValidation(SupplierStockRequest::class, '#form-create-supplier');

        return view('supplier-stock.create', compact('validator'));
    }

    public function store(SupplierStockRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        SupplierStock::create($validated)
            ? flash()->preset('create_success')
            : flash()->preset('create_failed');

        return redirect()->route('supplier-stock.index');
    }

    public function show(SupplierStock $supplierStock): View
    {
        $supplierStock->load('stocks');

        return view('supplier-stock.show', compact('supplierStock'));
    }

    public function edit(SupplierStock $supplierStock): View
    {
        $validator = $this->validationService
            ->generateValidation(SupplierStockRequest::class, '#form-edit-supplier');

        return view('supplier-stock.edit', compact(['supplierStock', 'validator']));
    }

    public function update(SupplierStockRequest $request, SupplierStock $supplierStock): RedirectResponse
    {
        $validated = $request->validated();

        $supplierStock->update($validated)
            ? flash()->preset('update_success')
            : flash()->preset('update_failed');

        return redirect()->route('supplier-stock.index');
    }

    public function destroy(SupplierStock $supplierStock): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $result = $supplierStock->delete();

        return response()->json($result ? true : false);
    }
}
