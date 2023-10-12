<?php

namespace App\Repositories\Person;
use App\Http\Requests\PersonRequest;
use App\Http\Requests\PersonUpdateRequest;

interface PersonRepository {
    public function fetchPersonById($id);
    public function insertPerson(PersonRequest $request);
    public function updatePerson(PersonUpdateRequest $request);
    public function deletePerson($id);
}
