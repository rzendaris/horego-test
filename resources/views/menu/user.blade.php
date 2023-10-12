@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ __('Users') }}</h1>
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
                        <i class="fas fa-plus fa-sm text-white-50"></i> Create New User
                    </button>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($data['users']); $i++)
                    <tr>
                        <td> {{ $i + 1 }} </td>
                        <td>{{ $data['users'][$i]->name }}</td>
                        <td>{{ $data['users'][$i]->email }}</td>
                        <td>{{ $data['users'][$i]->role->role_name }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#editModal{{ $data['users'][$i]->id }}">
                                <i class="fas fa-fw fa-pencil-alt"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal{{ $data['users'][$i]->id }}">
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
    <form method="post" action="{{url('user/create')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-dialog modal-primary" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New User</h4>
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
                        <label>Password *</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Role *</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            <option></option>
                            @foreach($data['roles'] as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
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

@foreach($data['users'] as $user)
    <!-- Edit Dialog -->
    <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form method="post" action="{{url('user/update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update User Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <input type="hidden" name="id" value="{{ $user->id }}" />
                        <input type="hidden" name="role_id" value="{{ $user->role_id }}" />
                        <input type="hidden" name="password" value="{{ $user->password }}" />
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
    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form method="post" action="{{url('user/delete')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete User Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="text-align:center">
                            <label>Are you sure you want to delete this User?</label>
                            <label>{{ $user->name }}</label>
                        </div>
                        <input type="hidden" name="name" value="{{ $user->name }}" />
                        <input type="hidden" name="email" value="{{ $user->email }}" />
                        <input type="hidden" name="role_id" value="{{ $user->role_id }}" />
                        <input type="hidden" name="password" value="{{ $user->password }}" />
                        <input type="hidden" name="id" value="{{ $user->id }}" />
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
