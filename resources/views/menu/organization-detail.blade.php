@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">{{ __('Organization') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        <div class="col-lg-4 order-lg-2">

            <div class="card shadow mb-4">
                <div class="card-profile-image mt-4" style="display:flex;justify-content:center;">
                    <img class="rounded-circle" width="150" height="150" src="{{ asset('storage/'.$data->logo) }}">
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h5 class="font-weight-bold">{{  $data->name }}</h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-profile-stats" style="display:flex;justify-content:center;">
                                <span class="description"><a class="nav-link" target="_blank" href="{{ $data->website }}">{{ $data->website }}</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">My Organization</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ url('organization/update') }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <h6 class="heading-small text-muted mb-4">Organization information</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Name<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="example@example.com" value="{{ $data->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ $data->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="last_name">Phone</label>
                                        <input type="text" id="phone" class="form-control" name="phone" placeholder="Last name" value="{{ $data->phone }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="last_name">Website</label>
                                        <input type="text" id="website" class="form-control" name="website" placeholder="Last name" value="{{ $data->website }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label for="exampleInputEmail1">Logo</label>
                                        <input type="file" class="form-control" id="logo" name="logo" placeholder="">
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{ $data->id }}"/>
                                <input type="hidden" name="account_manager_id" value="{{ $data->account_manager_id }}"/>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="d-sm-flex align-items-center justify-content-center mt-2">
            <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addModal">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New PIC
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($data->persons); $i++)
                    <tr>
                        <td> {{ $i + 1 }} </td>
                        <td>{{ $data->persons[$i]->name }}</td>
                        <td>{{ $data->persons[$i]->phone }}</td>
                        <td>{{ $data->persons[$i]->email }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#editModal{{ $data->persons[$i]->id }}">
                                <i class="fas fa-fw fa-pencil-alt"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal{{ $data->persons[$i]->id }}">
                                <i class="fas fa-fw fa-trash-alt"></i> Delete
                            </button>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Dialog -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" action="{{url('person/create')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-dialog modal-primary" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add PIC</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Phone *</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Avatar *</label>
                                <input type="file" class="form-control" id="avatar" name="avatar" placeholder="" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="organization_id" value="{{ $data->id }}" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </form>
    <!-- /.modal-dialog -->
</div>

@foreach($data->persons as $person)
    <!-- Edit Dialog -->
    <div class="modal fade" id="editModal{{ $person->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form method="post" action="{{url('person/update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update PIC Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $person->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $person->email }}" required>
                        </div>
                        <div class="form-group">
                            <label>Phone *</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $person->phone }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Avatar</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar" placeholder="">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="organization_id" value="{{ $person->organization_id }}" />
                        <input type="hidden" name="id" value="{{ $person->id }}" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
        <!-- /.modal-dialog -->
    </div>

    <!-- Delete Dialog -->
    <div class="modal fade" id="deleteModal{{ $person->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form method="post" action="{{url('person/delete')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete PIC Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="text-align:center">
                            <label>Are you sure you want to delete this user?</label>
                            <label>{{ $person->name }}</label>
                        </div>
                        <input type="hidden" name="name" value="{{ $person->name }}" />
                        <input type="hidden" name="email" value="{{ $person->email }}" />
                        <input type="hidden" name="phone" value="{{ $person->phone }}" />
                        <input type="hidden" name="organization_id" value="{{ $person->organization_id }}" />
                        <input type="hidden" name="id" value="{{ $person->id }}" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
        <!-- /.modal-dialog -->
    </div>
@endforeach
@endsection