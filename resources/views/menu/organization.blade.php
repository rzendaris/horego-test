@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ __('Organization') }}</h1>
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
    <div class="card-body">
        <div class="d-sm-flex align-items-center justify-content-center mt-2">
            <?php if(Auth::user()->role_id == 1): ?>
                <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addModal">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Create New Organization
                </button>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Account Manager</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < count($data['organizations']); $i++)
                <tr>
                    <td> {{ $i + 1 }} </td>
                    <td>
                        <a class="nav-link" href="{{ url('organization/detail/'.$data['organizations'][$i]->id) }}">{{ $data['organizations'][$i]->name }}</a>
                    </td>
                    <td>{{ $data['organizations'][$i]->phone }}</td>
                    <td>{{ $data['organizations'][$i]->email }}</td>
                    <td>{{ $data['organizations'][$i]->website }}</td>
                    <td>{{ $data['organizations'][$i]->account_manager->name }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#editModal{{ $data['organizations'][$i]->id }}">
                            <i class="fas fa-fw fa-pencil-alt"></i> Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal{{ $data['organizations'][$i]->id }}">
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

</div>

<!-- Add Dialog -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" action="{{url('organization/create')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-dialog modal-primary" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Organization</h4>
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
                    <div class="form-group">
                        <label>Website *</label>
                        <input type="text" class="form-control" id="website" name="website" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Account Manager *</label>
                        <select class="form-control" id="account_manager_id" name="account_manager_id" required>
                            <option></option>
                            @foreach($data['account_managers'] as $account_manager)
                                <option value="{{ $account_manager->id }}">{{ $account_manager->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Logo *</label>
                                <input type="file" class="form-control" id="logo" name="logo" placeholder="" required>
                            </div>
                        </div>
                    </div>
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

@foreach($data['organizations'] as $organization)
    <!-- Edit Dialog -->
    <div class="modal fade" id="editModal{{ $organization->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form method="post" action="{{url('organization/update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Organization Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $organization->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $organization->email }}" required>
                        </div>
                        <div class="form-group">
                            <label>Phone *</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $organization->phone }}" required>
                        </div>
                        <div class="form-group">
                            <label>Website *</label>
                            <input type="text" class="form-control" id="website" name="website" value="{{ $organization->website }}" required>
                        </div>
                        <div class="form-group">
                            <label>Account Manager *</label>
                            <select class="form-control" id="account_manager_id" name="account_manager_id" required>
                                <option value="{{ $organization->account_manager->id }}">{{ $organization->account_manager->name }}</option>
                                @foreach($data['account_managers'] as $account_manager_data)
                                    @if($organization->account_manager->id !== $account_manager_data->id)
                                        <option value="{{ $account_manager_data->id }}">{{ $account_manager_data->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo" placeholder="">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $organization->id }}" />
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
    <div class="modal fade" id="deleteModal{{ $organization->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form method="post" action="{{url('organization/delete')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Organization Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="text-align:center">
                            <label>Are you sure you want to delete this Organization?</label>
                            <label>{{ $organization->name }}</label>
                        </div>
                        <input type="hidden" name="name" value="{{ $organization->name }}" />
                        <input type="hidden" name="email" value="{{ $organization->email }}" />
                        <input type="hidden" name="phone" value="{{ $organization->phone }}" />
                        <input type="hidden" name="website" value="{{ $organization->website }}" />
                        <input type="hidden" name="account_manager_id" value="{{ $organization->account_manager_id }}" />
                        <input type="hidden" name="id" value="{{ $organization->id }}" />
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
