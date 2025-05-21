<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Region;
use App\Services\ValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class CustomerController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $customers = Customer::with([
                'category',
                'region'
            ])
                ->select([
                    'customer_id',
                    'customer_category_id',
                    'customer_region_id',
                    'customer_name',
                    'customer_credit_limit',
                    'customer_status'
                ]);

            return DataTables::of($customers)
                ->addIndexColumn()
                ->escapeColumns()
                ->addColumn('actions', fn($customer) => [
                    'edit' => route('customer.edit', $customer->customer_id),
                    'delete' => route('customer.destroy', $customer->customer_id)
                ])
                ->toJson();
        }

        return view('customer.index');
    }

    public function create(): View
    {
        $validator = $this->validationService
            ->generateValidation(CustomerRequest::class, '#form-create-customer');

        $regions = Region::getRegionDropdown();

        $categories = Category::getCustomerCategories();

        return view('customer.create', compact(['validator', 'regions', 'categories']));
    }

    public function store(CustomerRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Customer::create($validated)
            ? flash()->preset('create_success')
            : flash()->preset('create_failed');

        return redirect()->route('customer.index');
    }

    public function edit(Customer $customer): View
    {
        $validator = $this->validationService
            ->generateValidation(CustomerRequest::class, '#form-edit-customer');

        $regions = Region::getRegionDropdown();

        $categories = Category::getCustomerCategories();

        return view('customer.edit', compact(['validator', 'regions', 'categories', 'customer']));
    }

    public function update(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validated();

        $customer->update($validated)
            ? flash()->preset('update_success')
            : flash()->preset('update_failed');

        return redirect()->route('customer.index');
    }

    public function destroy(Customer $customer): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        if ($customer->customer_id == 1) {
            return response()->json(false);
        }

        $result = $customer->update([
            'customer_status' => 0
        ]);

        return response()->json($result ? true : false);
    }
}
