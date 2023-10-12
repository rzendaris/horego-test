<?php

namespace App\Repositories\Organization;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Organization;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\OrganizationUpdateRequest;
use App\Traits\Upload;

class EloquentOrganizationRepository implements OrganizationRepository
{
    use Upload;

    public function fetchOrganization()
    {
        $query_builder = Organization::with('account_manager', 'persons')->where('status', 1);
        if (Auth::user()->role_id == 2){
            $query_builder = $query_builder->where('account_manager_id', Auth::user()->id);
        }
        return $query_builder;
    }

    public function fetchOrganizationById($id)
    {
        $organization = $this->fetchOrganization()->where('id', $id)->first();
        return $organization;
    }

    public function insertOrganization(OrganizationRequest $request)
    {
        $organization = new Organization;
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->phone = $request->phone;
        $organization->website = $request->website;
        $organization->account_manager_id = $request->account_manager_id;
        if ($request->hasFile('logo')) {
            $logo = $this->UploadFile($request->file('logo'), 'organizations');
            $organization->logo = $logo;
        }
        $organization->save();
        return $organization;
    }

    public function updateOrganization(OrganizationUpdateRequest $request)
    {
        $organization = $this->fetchOrganizationById($request->id);
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->phone = $request->phone;
        $organization->website = $request->website;
        $organization->account_manager_id = $request->account_manager_id;
        if ($request->hasFile('logo')) {
            $logo = $this->UploadFile($request->file('logo'), 'organizations');
            $organization->logo = $logo;
        }
        $organization->save();
        return $organization;
    }

    public function deleteOrganization($id)
    {
        $organization = $this->fetchOrganizationById($id);
        if(isset($organization)){
            $organization->delete();
        }
        return $id;
    }
}