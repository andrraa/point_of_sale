<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\ValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategoryController
{
    protected $validationService;


    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    // ITEM CATEGORY
    public function itemCategory(): View
    {
        $categories = Cache::remember(Category::ITEM_CACHE_KEY, 84600, function () {
            return Category::query()->select([
                'category_id',
                'category_code',
                'category_name'
            ])
                ->where('category_type', Category::ITEM_CATEGORY)
                ->get();
        });

        return view('settings.category.index', compact('categories'));
    }

    public function createCategoryItem(): View
    {
        $validator = $this->validationService->generateValidation(CategoryRequest::class, '#form-create-category');

        return view('settings.category.create', compact(['validator']));
    }

    public function storeCategoryItem(CategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $result = Category::create($validated);

        if ($result) {
            $this->clearItemCache();

            flash()->preset('create_success');
        } else {
            flash()->preset('create_failed');
        }

        return redirect()->route('category.index');
    }

    public function editCategoryItem(Category $category): View
    {
        $validator = $this->validationService->generateValidation(CategoryRequest::class, '#form-edit-category');

        return view('settings.category.edit', compact(['category', 'validator']));
    }

    public function updateCategoryItem(CategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();

        $result = $category->update($validated);

        if ($result) {
            $this->clearItemCache();

            flash()->preset('update_success');
        } else {
            flash()->preset('update_failed');
        }

        return redirect()->route('category.index');
    }

    private function clearItemCache(): void
    {
        Cache::forget(Category::ITEM_CACHE_KEY);
        Cache::forget(Category::ITEM_DROPDOWN_CACHE_KEY);
    }

    // CUSTOMER CATEGORY
    public function customerCategory(): View
    {
        $customerCategories = Cache::remember(Category::CUSTOMER_CACHE_KEY, 84600, function () {
            return Category::query()
                ->select([
                    'category_id',
                    'category_code',
                    'category_name',
                ])
                ->where('category_type', Category::CATEGORY_CUSTOMER)
                ->get();
        });

        return view('settings.customer.index', compact('customerCategories'));
    }

    public function createCategoryCustomer(): View
    {
        $validator = $this->validationService->generateValidation(CategoryRequest::class, '#form-create-subcategory');

        return view('settings.customer.create', compact(['validator']));

    }

    public function storeCategoryCustomer(CategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Category::create($validated)
            ? flash()->preset('create_success')
            : flash()->preset('create_failed');

        $this->clearCustomerCache();

        return redirect()->route('customer-category.index');
    }

    public function editCategoryCustomer(Category $category): View
    {
        $validator = $this->validationService->generateValidation(CategoryRequest::class, '#form-edit-subcategory');

        return view('settings.customer.edit', compact(['category', 'validator']));
    }

    public function updateCategoryCustomer(CategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();

        $category->update($validated)
            ? flash()->preset('update_success')
            : flash()->preset('update_failed');

        $this->clearCustomerCache();

        return redirect()->route('customer-category.index');
    }

    private function clearCustomerCache(): void
    {
        Cache::forget(Category::CUSTOMER_CACHE_KEY);
        Cache::forget(Category::CUSTOMER_DROPDOWN_CACHE_KEY);
    }

    // DESTROY CATEGORY & SUBCATEGORY
    public function deleteCategory(Category $category): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $category->category_type === Category::ITEM_CATEGORY
            ? $this->clearItemCache()
            : $this->clearCustomerCache();

        $result = $category->delete();

        $result ? flash()->preset('delete_success') : flash()->preset('delete_failed');

        return response()->json($result ? true : false);
    }
}
