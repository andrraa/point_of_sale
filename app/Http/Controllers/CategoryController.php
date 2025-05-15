<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Services\ValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategoryController
{
    protected $validationService;
    protected $itemCacheKey = 'item_cache_key';
    protected $customerCacheKey = 'customer_cache_key';

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
                ->whereNull('category_parent_id')
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

    public function deleteCategoryItem()
    {

    }

    // CUSTOMER CATEGORY
    public function subCategoryIndex(): View
    {
        $subCategories = Category::with('parent')
            ->select([
                'category_id',
                'category_code',
                'category_name',
                'category_parent_id'
            ])
            ->whereNotNull('category_parent_id')
            ->get();

        return view('settings.sub-category.index', compact('subCategories'));
    }

    public function createSubCategoryPage(): View
    {
        $validator = $this->validationService->generateValidation(SubCategoryRequest::class, '#form-create-subcategory');

        $categories = Category::whereNull('category_parent_id')
            ->select([
                'category_id',
                'category_name'
            ])
            ->pluck('category_name', 'category_id');

        return view('settings.sub-category.create', compact(['validator', 'categories']));

    }

    public function createSubCategory(SubCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Category::create($validated)
            ? flash()->preset('create_success')
            : flash()->preset('create_failed');

        return redirect()->route('subcategory.index');
    }

    public function editSubCategoryPage(Category $category): View
    {
        $validator = $this->validationService->generateValidation(SubCategoryRequest::class, '#form-edit-subcategory');

        $categories = Category::whereNull('category_parent_id')
            ->select([
                'category_id',
                'category_name'
            ])
            ->pluck('category_name', 'category_id');

        return view('settings.sub-category.edit', compact(['category', 'validator', 'categories']));
    }

    public function updateSubCategory(SubCategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();

        $category->update($validated)
            ? flash()->preset('update_success')
            : flash()->preset('update_failed');

        return redirect()->route('subcategory.index');
    }

    // DESTROY CATEGORY & SUBCATEGORY
    public function deleteCategory(Category $category): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $result = $category->delete();

        $result ? flash()->preset('delete_success') : flash()->preset('delete_failed');

        return response()->json($result ? true : false);
    }
}
