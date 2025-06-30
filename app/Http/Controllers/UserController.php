<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\ValidationService;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(): View
    {
        $users = User::with('role')
            ->select(['user_id', 'full_name', 'username', 'user_role_id', 'active'])
            ->get();

        return view('settings.user.index', compact('users'));
    }

    public function create(): View
    {
        $validator = $this->validationService->generateValidation(UserRequest::class, '#form-create-user');

        $state = 'create';

        $roles = Role::getRoles();

        return view('settings.user.create', compact(['validator', 'state', 'roles']));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated)
            ? flash()->preset('create_success')
            : flash()->preset('create_failed');

        return redirect()->route('user.index');
    }

    public function edit(User $user): View
    {
        $validator = $this->validationService->generateValidation(UserRequest::class, '#form-edit-user');

        $roles = Role::getRoles();

        return view('settings.user.edit', compact(['user', 'validator', 'roles']));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated)
            ? flash()->preset('update_success')
            : flash()->preset('update_failed');

        return redirect()->route('user.index');
    }

    public function destroy(User $user): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $result = $user->delete();

        $result ? flash()->preset('delete_success') : flash()->preset('delete_failed');

        return response()->json($result ? true : false);
    }
}
