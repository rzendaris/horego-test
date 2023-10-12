<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Repositories\Organization\EloquentOrganizationRepository;
use App\Repositories\User\EloquentUserRepository;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\OrganizationUpdateRequest;

class OrganizationController extends Controller
{
    protected $organizationRepository;
    protected $userRepository;

    public function __construct(
        EloquentOrganizationRepository $organizationRepository,
        EloquentUserRepository $userRepository

    ) {
        $this->organizationRepository = $organizationRepository;
        $this->userRepository = $userRepository;
    }

    public function index(): View
    {
        $organizations = $this->organizationRepository->fetchOrganization()->get();
        $account_managers = $this->userRepository->fetchAccountManager();

        $data = array(
            'organizations' => $organizations,
            'account_managers' => $account_managers
        );
        return view('menu.organization')->with('data', $data);
    }

    public function fetchById(int $id)
    {
        $organization = $this->organizationRepository->fetchOrganizationById($id);
        if(isset($organization)){
            return view('menu.organization-detail')->with('data', $organization);
        } else {
            return redirect()->route('organization-view')->withErrors(['msg' => 'Organization not found or Unauthorized Access']);;
        }
    }

    public function create(OrganizationRequest $request): RedirectResponse
    {
        $this->organizationRepository->insertOrganization($request);
        return redirect()->route('organization-view');
    }

    public function update(OrganizationUpdateRequest $request): RedirectResponse
    {
        $this->organizationRepository->updateOrganization($request);
        return redirect()->route('organization-view');
    }

    public function delete(OrganizationUpdateRequest $request): RedirectResponse
    {
        $this->organizationRepository->deleteOrganization($request->id);
        return redirect()->route('organization-view')->with('msg', 'Organization has been delete');;
    }
}
