<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Session;

class StoreController
{
    public function index(): View
    {
        $store = Store::query()->select([
            'store_id',
            'store_name',
            'store_address',
            'store_phone_number'
        ])->first();

        return view('settings.store.index', compact('store'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        Session::remove('store');

        $validated = $request->validated();

        $store = Store::first();

        $store->update($validated);

        Session::put(['store' => $store]);

        flash()->preset('update_success');

        return redirect()->back();
    }
}
