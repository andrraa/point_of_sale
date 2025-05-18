<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegionRequest;
use App\Models\Region;
use App\Services\ValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class RegionController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(): View
    {
        $regions = Cache::remember(Region::REGION_CACHE, 86400, function () {
            return Region::query()
                ->select(['region_id', 'region_code', 'region_name'])
                ->get();
        });

        return view('settings.region.index', compact('regions'));
    }

    public function create(): View
    {
        $validator = $this->validationService->generateValidation(RegionRequest::class, '#form-create-region');

        return view('settings.region.create', compact('validator'));
    }

    public function store(RegionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $result = Region::create($validated);

        if ($result) {
            $this->clearCache();

            flash()->preset('create_success');
        } else {
            flash()->preset('create_failed');
        }

        return redirect()->route('region.index');
    }

    public function edit(Region $region): View
    {
        $validator = $this->validationService->generateValidation(RegionRequest::class, '#form-edit-region');

        return view('settings.region.edit', compact(['region', 'validator']));
    }

    public function update(RegionRequest $reqeust, Region $region): RedirectResponse
    {
        $validated = $reqeust->validated();

        $result = $region->update($validated);

        if ($result) {
            $this->clearCache();

            flash()->preset('update_success');
        } else {
            flash()->preset('update_failed');
        }

        return redirect()->route('region.index');
    }

    public function destroy(Region $region): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $result = $region->delete();

        if ($result) {
            $this->clearCache();

            flash()->preset('delete_success');
        } else {
            flash()->preset('delete_failed');
        }

        return response()->json($result ? true : false);
    }

    private function clearCache(): void
    {
        Cache::forget(Region::REGION_CACHE);
        Cache::forget(Region::REGION_DROPDOWN_CACHE);
    }
}
