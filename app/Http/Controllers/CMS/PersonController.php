<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Repositories\Person\EloquentPersonRepository;
use App\Http\Requests\PersonRequest;
use App\Http\Requests\PersonUpdateRequest;

class PersonController extends Controller
{
    protected $personRepository;

    public function __construct(
        EloquentPersonRepository $personRepository

    ) {
        $this->personRepository = $personRepository;
    }

    public function create(PersonRequest $request): RedirectResponse
    {
        $this->personRepository->insertPerson($request);
        return redirect()->route('organization-view');
    }

    public function update(PersonUpdateRequest $request): RedirectResponse
    {
        $this->personRepository->updatePerson($request);
        return redirect()->route('organization-view');
    }

    public function delete(PersonUpdateRequest $request): RedirectResponse
    {
        $this->personRepository->deletePerson($request->id);
        return redirect()->route('organization-view');
    }
}
