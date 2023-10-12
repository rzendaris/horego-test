<?php

namespace App\Repositories\Organization;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\OrganizationUpdateRequest;

interface OrganizationRepository {
    public function fetchOrganization();
    public function fetchOrganizationById($id);
    public function insertOrganization(OrganizationRequest $request);
    public function updateOrganization(OrganizationUpdateRequest $request);
    public function deleteOrganization($id);
}
