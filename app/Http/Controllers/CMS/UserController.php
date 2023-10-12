<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Repositories\User\EloquentUserRepository;
use App\Repositories\Role\EloquentRoleRepository;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(
        EloquentUserRepository $userRepository,
        EloquentRoleRepository $roleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index(): View
    {
        $users = $this->userRepository->fetchUser()->get();
        $roles = $this->roleRepository->fetchRole();

        $data = array(
            "users" => $users,
            "roles" => $roles
        );
        return view('menu.user')->with('data', $data);
    }

    public function create(UserRequest $request): RedirectResponse
    {
        $this->userRepository->insertUser($request);
        return redirect()->route('user-view');
    }

    public function update(UserUpdateRequest $request): RedirectResponse
    {
        $this->userRepository->updateUser($request);
        return redirect()->route('user-view');
    }

    public function delete(UserUpdateRequest $request): RedirectResponse
    {
        $this->userRepository->deleteUser($request->id);
        return redirect()->route('user-view');
    }
}
