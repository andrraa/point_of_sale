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
    protected $itemCacheKey = CATEGORY::ITEM_CACHE_KEY;
    protected $customerCacheKey = CATEGORY::CUSTOMER_CACHE_KEY;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    // ITEM CATEGORY
    public function itemCategory(): View
    {
        $categories = Cache::remember($this->itemCacheKey, 84600, function () {
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
            Cache::forget($this->itemCacheKey);
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
            Cache::forget($this->itemCacheKey);
            flash()->preset('update_success');
        } else {
            flash()->preset('update_failed');
        }

        return redirect()->route('category.index');
    }

    // CUSTOMER CATEGORY
    public function customerCategory(): View
    {
        $customerCategories = Category::query()
            ->select([
                'category_id',
                'category_code',
                'category_name',
            ])
            ->where('category_type', Category::CATEGORY_CUSTOMER)
            ->get();

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

        return redirect()->route('customer-category.index');
    }

    // DESTROY CATEGORY & SUBCATEGORY
    public function deleteCategory(Category $category): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $category->category_type === Category::ITEM_CATEGORY
            ? Cache::forget($this->itemCacheKey)
            : Cache::forget($this->customerCacheKey);

        $result = $category->delete();

        $result ? flash()->preset('delete_success') : flash()->preset('delete_failed');

        return response()->json($result ? true : false);
    }
}
