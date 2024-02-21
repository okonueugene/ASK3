@extends('admin.layouts.layout')
@section('content')
    <!-- content -->
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">{{ $title }}</h3>
                                <div class="nk-block-des text-soft">
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                        data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li><a href="javascript:void(0)"
                                                    class="btn btn-white btn-dim btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#addUser"><em class="icon ni ni-upload"></em><span>Add
                                                        User</span></a></li>

                                            </li>
                                        </ul>
                                    </div><!-- .toggle-expand-content -->
                                </div><!-- .toggle-wrap -->
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner">
                                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false"
                                    id="users-table">
                                    <thead>
                                        <tr class="nk-tb-item">
                                            <th class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input" id="uid1">
                                                    <label class="custom-control-label" for="uid1"></label>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col"><span class="sub-text">Name</span></th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Email</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Role</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col nk-tb-col-check">
                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="uid{{ $user->id }}">
                                                        <label class="custom-control-label"
                                                            for="uid{{ $user->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-primary">
                                                            <span>{{ $user->name[0] }}</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{ $user->name }} <span
                                                                    class="dot dot-success d-md-none ml-1"></span></span>
                                                            <span>{{ $user->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb">
                                                    <span>{{ $user->email }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span>{{ $user->role }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span class="tb-status text-success">Active</span>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-icon btn-trigger edit-user-modal"
                                                                data-bs-toggle="modal" data-bs-target="#editUser"
                                                                data-user="{{ $user }}">
                                                                <em class="icon ni ni-edit-alt"></em>
                                                            </a>

                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.deleteUser', $user->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-danger"><em
                                                                        class="icon ni ni-trash"></em></button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr><!-- .nk-tb-item -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addUser">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"><em
                        class="icon ni ni-cross"></em></a>
                <div class="modal-body">
                    <h5 class="title">Add User</h5>
                    <form action="{{ route('admin.addUser') }}" method="post">
                        @csrf
                        <div class="row g-gs">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="name" name="name"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span>Email</span>
                                    </label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control" id="email" name="email"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" id="password" name="password"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="role">Role</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="user_type" name="user_type" required>
                                            <option value="admin">Admin</option>
                                            <option value="client">User</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <ul class="align-center flex-wrap g-3">
                                    <li>
                                        <button type="submit" class="btn btn-lg btn-primary">Add User</button>
                                    </li>
                                    <li>
                                        <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"><em
                        class="icon ni ni-cross"></em></a>
                <div class="modal-body">
                    <h5 class="title">Edit User</h5>
                    <form action="{{ route('admin.updateUser', $user->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="row g-gs">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="new_name">Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="new_name" name="new_name"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span>Email</span>
                                    </label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control" id="new_email" name="new_email"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span>Role</span>
                                    </label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="new_role" name="new_role" required>
                                            <option value="admin">Admin</option>
                                            <option value="client">User</option>    
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="new_password">Password</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" id="new_password"
                                            name="new_password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <ul class="align-center flex-wrap g-3">
                                    <li>
                                        <button type="submit" class="btn btn-lg btn-primary">Update User</button>
                                    </li>
                                    <li>
                                        <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#users-table').DataTable({
            "order": [],
            'language': {
                'lengthMenu': 'Display _MENU_ records per page',
                'zeroRecords': 'Nothing found - sorry',
                'info': 'Showing page _PAGE_ of _PAGES_',
                'infoEmpty': 'No records available',
                'infoFiltered': '(filtered from _MAX_ total records)',
                'search': 'Search',
                'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
                }
            }
        });
    });
    //check if the password and password_confirmation match
    $('#password, #password_confirmation').on('keyup', function() {
        if ($('#password').val() == $('#password_confirmation').val()) {
            $('#message').html('Matching').css('color', 'green');
        } else
            $('#message').html('Not Matching').css('color', 'red');
    });

    //handle the edit user modal
    $(document).ready(function() {

        $('#editUser').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userData = button.data('user'); // Extract user data from the button
            console.log(userData);

            // Populate the modal with user data
            $('#new_name').val(userData.name);
            $('#new_email').val(userData.email);
            //role is a select input so we need to set the value using the val() method
            $('#new_role').val(userData.role);
    
            // Clear the password field for security reasons
            $('#new_password').val('');
        });
    });
</script>
