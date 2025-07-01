<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Region;
use App\Models\Supplier;
use App\Services\ValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SupplierController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $suppliers = Supplier::with('region')
                ->select([
                    'supplier_id',
                    'supplier_code',
                    'supplier_name',
                    'supplier_region_id'
                ]);

            if ($request->filled('region_id')) {
                $suppliers->where('supplier_region_id', $request->region_id);
            }

            return DataTables::of($suppliers)
                ->addIndexColumn()
                ->escapeColumns()
                ->addColumn('actions', fn($supplier) => [
                    'edit' => route('supplier.edit', $supplier->supplier_id),
                    'delete' => route('supplier.destroy', $supplier->supplier_id)
                ])
                ->toJson();
        }

        $regions = Region::getRegionDropdown();

        return view('supplier.index', compact('regions'));
    }

    public function create(): View
    {
        $validator = $this->validationService->generateValidation(SupplierRequest::class, '#form-create-supplier');

        $regions = Region::getRegionDropdown();

        return view('supplier.create', compact(['validator', 'regions']));
    }

    public function store(SupplierRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Supplier::create($validated)
            ? flash()->preset('create_success')
            : flash()->preset('create_failed');

        return redirect()->route('supplier.index');
    }

    public function edit(Supplier $supplier): View
    {
        $validator = $this->validationService->generateValidation(SupplierRequest::class, '#form-edit-supplier');

        $regions = Region::getRegionDropdown();

        return view('supplier.edit', compact(['supplier', 'validator', 'regions']));
    }

    public function update(SupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $validated = $request->validated();

        $supplier->update($validated)
            ? flash()->preset('update_success')
            : flash()->preset('update_failed');

        return redirect()->route('supplier.index');
    }

    public function destroy(Supplier $supplier): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $result = $supplier->delete();

        return response()->json($result ? true : false);
    }
}
