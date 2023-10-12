<?php

namespace App\Repositories\Person;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Person;
use App\Http\Requests\PersonRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Traits\Upload;

class EloquentPersonRepository implements PersonRepository
{
    use Upload;

    public function fetchPersonById($id)
    {
        $person = Person::where('status', 1)->where('id', $id)->first();
        return $person;
    }

    public function insertPerson(PersonRequest $request)
    {
        $person = new Person;
        $person->name = $request->name;
        $person->email = $request->email;
        $person->phone = $request->phone;
        $person->organization_id = $request->organization_id;
        if ($request->hasFile('avatar')) {
            $avatar = $this->UploadFile($request->file('avatar'), 'Persons');
            $person->avatar = $avatar;
        }
        $person->save();
        return $person;
    }

    public function updatePerson(PersonUpdateRequest $request)
    {
        $person = $this->fetchPersonById($request->id);
        $person->name = $request->name;
        $person->email = $request->email;
        $person->phone = $request->phone;
        $person->organization_id = $request->organization_id;
        if ($request->hasFile('avatar')) {
            $avatar = $this->UploadFile($request->file('avatar'), 'Persons');
            $person->avatar = $avatar;
        }
        $person->save();
        return $person;
    }

    public function deletePerson($id)
    {
        $person = $this->fetchPersonById($id);
        if(isset($person)){
            $person->delete();
        }
        return $person;
    }
}