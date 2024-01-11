@extends('admin.layouts.layout')
@section('content')
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
                                                    data-bs-target="#addGuardModal"><em
                                                        class="icon ni ni-upload-cloud"></em><span>Add Guard</span></a>
                                            </li>
                                            <li><a href="javascript:void(0)"
                                                    class="btn btn-white btn-dim btn-outline-primary"
                                                    onclick="AssignGuardToSite()"><em
                                                        class="icon ni ni-reports"></em><span>Assign To Site</span></a></li>
                                        </ul>
                                    </div><!-- .toggle-expand-content -->
                                </div><!-- .toggle-wrap -->
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input" id="uid">
                                                    <label class="custom-control-label" for="uid"></label>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col"><span class="sub-text">Name</span></th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Email</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Phone</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">ID Number</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Site</span>
                                            </th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span>
                                            </th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Last Login</span>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Action</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($guards) == 0)
                                            <tr>
                                                <td colspan="8" class="text-center">No Guards Found</td>
                                            </tr>
                                        @endif

                                        @foreach ($guards as $guard)
                                            <tr>
                                                <td class="nk-tb-col nk-tb-col-check">
                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                        <input type="checkbox" class="custom-control-input" id="uid1">
                                                        <label class="custom-control-label" for="uid1"></label>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                                            <span>{{ substr($guard->name, 0, 1) }}</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{ $guard->name }} <span
                                                                    class="dot dot-success d-md-none ml-1"></span></span>
                                                            <span>{{ $guard->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb">
                                                    <span>{{ $guard->email }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span>{{ $guard->phone }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span>{{ $guard->id_number }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    @if ($guard->site === null)
                                                        <span class="badge bg-danger">Not Assigned</span>
                                                    @else
                                                        <span>{{ $guard->site->name }}</span>
                                                    @endif
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    @if ($guard->is_active === 1)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-warning">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span>{{ $guard->last_login_at ?? 'N/A' }}</span>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">

                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#"
                                                                    class="dropdown-toggle btn btn-icon btn-trigger"
                                                                    data-bs-toggle="dropdown"><em
                                                                        class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li>
                                                                            <a href="javascript:void(0)"
                                                                                onclick="editGuard({{ $guard->id }})">
                                                                                <em class="icon ni ni-edit"></em>
                                                                                <span>Edit Guard</span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)"
                                                                                data-bs-toggle="modal"
                                                                                onclick="editGuardPassword({{ $guard->id }})">
                                                                                <em class="icon ni ni-lock"></em><span>Change
                                                                                    Password</span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)"
                                                                                onclick="toggleGuardStatus({{ $guard->id }})">
                                                                                @if ($guard->is_active === 1)
                                                                                    <em class="icon ni ni-cross"></em><span>Deactivate
                                                                                    </span>
                                                                                @else
                                                                                    <em class="icon ni ni-check"></em><span>Activate
                                                                                    </span>
                                                                                @endif
                                                                            </a>
                                                                        </li>
                                                                        <li class="divider"></li>
                                                                        <li>
                                                                            <a href="javascript:void(0)"
                                                                                onclick="disassociateGuard({{ $guard->id }})"><em
                                                                                    class="icon ni ni-na"></em><span>Disassociate
                                                                                    Guard
                                                                                </span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a
                                                                                href="javascript:void(0)"onclick="deleteGaurd({{ $guard->id }})"><em
                                                                                    class="icon ni ni-trash"></em><span>Delete
                                                                                    Guard</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input" id="uid">
                                                    <label class="custom-control-label" for="uid"></label>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col"><span class="sub-text">Name</span></th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Email</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Phone</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">ID Number</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Site</span>
                                            </th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span>
                                            </th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Last Login</span>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Action</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($guards) == 0)
                                            <tr>
                                                <td colspan="8" class="text-center">No Guards Found</td>
                                            </tr>
                                        @endif

                                        @foreach ($guards as $guard)
                                            <tr>
                                                <td class="nk-tb-col nk-tb-col-check">
                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="uid1">
                                                        <label class="custom-control-label" for="uid1"></label>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                                            <span>{{ substr($guard->name, 0, 1) }}</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{ $guard->name }} <span
                                                                    class="dot dot-success d-md-none ml-1"></span></span>
                                                            <span>{{ $guard->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb">
                                                    <span>{{ $guard->email }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span>{{ $guard->phone }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span>{{ $guard->id_number }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    @if (!$guard->site)
                                                        <span class="badge bg-danger">Not Assigned</span>
                                                    @else
                                                        <span>{{ $guard->site->name }}</span>
                                                    @endif
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    @if ($guard->is_active == 1)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-warning">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span>{{ $guard->last_login_at ?? 'N/A' }}</span>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">

                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#"
                                                                    class="dropdown-toggle btn btn-icon btn-trigger"
                                                                    data-bs-toggle="dropdown"><em
                                                                        class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li>
                                                                            <a href="javascript:void(0)"
                                                                                onclick="editGuard({{ $guard->id }})">
                                                                                <em class="icon ni ni-edit"></em>
                                                                                <span>Edit Guard</span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)"
                                                                                data-bs-toggle="modal"
                                                                                onclick="editGuardPassword({{ $guard->id }})">
                                                                                <em class="icon ni ni-lock"></em><span>Change
                                                                                    Password</span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)"
                                                                                onclick="toggleGuardStatus({{ $guard->id }})">
                                                                                @if ($guard->is_active === 1)
                                                                                    <em
                                                                                        class="icon ni ni-cross"></em><span>Deactivate
                                                                                    </span>
                                                                                @else
                                                                                    <em
                                                                                        class="icon ni ni-check"></em><span>Activate
                                                                                    </span>
                                                                                @endif
                                                                            </a>
                                                                        </li>
                                                                        <li class="divider"></li>
                                                                        <li>
                                                                            <a href="javascript:void(0)"
                                                                                onclick="disassociateGuard({{ $guard->id }})"><em
                                                                                    class="icon ni ni-na"></em><span>Disassociate
                                                                                    Guard
                                                                                </span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a
                                                                                href="javascript:void(0)"onclick="deleteGaurd({{ $guard->id }})"><em
                                                                                    class="icon ni ni-trash"></em><span>Delete
                                                                                    Guard</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addGuardModal" tabindex="-1" aria-labelledby="addGuardModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add A Guard</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="addGuardForm" action="{{ route('admin.addGuard') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Guard Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Guard Email</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Guard Phone</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="id_number" class="form-label">Guard ID/SIA No</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="id_number" name="id_number" required>
                            </div>
                            @error('id_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Guard Password</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Add Guard</button>
                            <button type="button" class="btn btn-md btn-danger float-end"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <span class="sub-text">AskariTechnologies {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editGuardModal" tabindex="-1" aria-labelledby="editGuardModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Edit A Guard</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="editGuardForm">
                        <div class="form-group">
                            <label for="name" class="form-label">Guard Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="edit-name" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Guard Email</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control" id="edit-email" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Guard Phone</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="edit-phone" name="phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id_number" class="form-label">Guard ID Number</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="edit-id_number" name="id_number">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Update
                                Guard</button>
                            <button type="button" class="btn btn-md btn-danger float-end"
                                data-bs-dismiss="modal">Close</button>

                        </div>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <span class="sub-text">AskariTechnologies {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editGuardPasswordModal" tabindex="-1" aria-labelledby="editGuardPasswordModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Update Guard Password</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="editGuardPasswordForm">
                        <div class="form-group">
                            <label for="name" class="form-label">Guard Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="edit-password-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Guard Password</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control" id="edit-password" name="password">

                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Update
                                Password</button>
                            <button type="button" class="btn btn-md btn-danger float-end"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <span class="sub-text">AskariTechnologies {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="assignSiteGuardModal" tabindex="-1" aria-labelledby="assignSiteGuardExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Assign Guard To Site</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="assigniteGuardForm">
                        <div class="form-group">
                            <label for="name" class="form-label">Select Guard</label>
                            <div class="form-control-wrap">
                                <select name="guard_id" id="guard_id" class="custom-select form-select"
                                    data-search="on">
                                    <option value="">Select Guard</option>
                                    @foreach ($freeGuards as $guard)
                                        <option value="{{ $guard->id }}">{{ $guard->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-label">Select Site</label>
                            <div class="form-control-wrap">
                                <select name="site_id" id="site_id" class="form-control">
                                    <option value="">Select Site</option>
                                    @foreach ($sites as $site)
                                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Assign
                                Guard</button>
                            <button type="button" class="btn btn-md btn-danger float-end"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <span class="sub-text">AskariTechnologies {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function clearForm() {
        //clear all forms
        $('#editGuardForm').trigger('reset');
        $('#editGuardPasswordForm').trigger('reset');


    }


    function editGuard(id) {
        let url = `{{ route('admin.editGuard', ':id') }}`;
        url = url.replace(':id', id);
        axios.get(url)
            .then(function(response) {
                let guard = response.data.guard;
                $('#edit-name').val(guard.name);
                $('#edit-email').val(guard.email);
                $('#edit-phone').val(guard.phone);
                $('#edit-id_number').val(guard.id_number);
                $('#editGuardModal').modal('show');
            })
            .catch(function(error) {
                console.log(error);
            })

        //on submit
        $('#editGuardModal').on('submit', function(e) {
            e.preventDefault();
            let name = $('#edit-name').val();
            let email = $('#edit-email').val();
            let phone = $('#edit-phone').val();
            let id_number = $('#edit-id_number').val();
            var formData = {
                name: name,
                email: email,
                phone: phone,
                id_number: id_number
            };
            let url = `{{ route('admin.updateGuard', ':id') }}`;
            url = url.replace(':id', id);
            axios({
                    method: 'PATCH',
                    url: url,
                    data: formData
                })
                .then(function(response) {
                    let successMessage = 'Guard updated successfully';
                    displaySuccess(successMessage);
                    $('#editGuardModal').modal('hide');

                    //clear form
                    clearForm();

                    //refresh page
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                })
                .catch(function(error) {
                    console.log(error);
                    let errorMessage = error.response.data.message ? error.response.data.message :
                        'An error occured. Please try again';
                    displayError(errorMessage);
                });
        });
    }

    function editGuardPassword(id) {
        let url = `{{ route('admin.editGuard', ':id') }}`;
        url = url.replace(':id', id);
        axios.get(url)
            .then(function(response) {
                let guard = response.data.guard;
                $('#edit-password-name').val(guard.name);
                $('#editGuardPasswordModal').modal('show');
            })
            .catch(function(error) {
                console.log(error);
            })

        //on submit
        $('#editGuardPasswordModal').on('submit', function(e) {
            e.preventDefault();
            let password = $('#edit-password').val();
            var formData = {
                password: password,
            };
            let url = `{{ route('admin.updateGuardPassword', ':id') }}`;
            url = url.replace(':id', id);
            axios({
                    method: 'PATCH',
                    url: url,
                    data: formData
                })
                .then(function(response) {
                    let successMessage = 'Guard password updated successfully';
                    displaySuccess(successMessage);
                    $('#editGuardPasswordModal').modal('hide');

                    //clear form
                    clearForm();

                    //refresh page
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                })
                .catch(function(error) {
                    console.log(error);
                    let errorMessage = error.response.data.message ? error.response.data.message :
                        'An error occured. Please try again';
                    displayError(errorMessage);
                });
        });
    }

    function disassociateGuard(id) {
        let url = `{{ route('admin.disassociateGuard', ':id') }}`;
        url = url.replace(':id', id);
        axios.put(url)
            .then(function(response) {
                console.log(response.data.guard);
                let successMessage = 'Guard disassociated successfully';
                displaySuccess(successMessage);
                //refresh page
                setTimeout(function() {
                    location.reload();
                }, 2000);
            })
            .catch(function(error) {
                console.log(error);
                let errorMessage = error.response.data.message ? error.response.data.message :
                    'An error occured. Please try again';
                displayError(errorMessage);
            })
    }

    function toggleGuardStatus(id) {
        let url = `{{ route('admin.changeGuardStatus', ':id') }}`;
        url = url.replace(':id', id);
        axios.post(url)
            .then(function(response) {
                let successMessage = 'Guard status updated successfully';
                displaySuccess(successMessage);
                //refresh page
                setTimeout(function() {
                    location.reload();
                }, 2000);
            })
            .catch(function(error) {
                console.log(error);
                let errorMessage = error.response.data.message ? error.response.data.message :
                    'An error occured. Please try again';
                displayError(errorMessage);
            })
    }

    function deleteGaurd(id) {
        let url = `{{ route('admin.deleteGuard', ':id') }}`;
        url = url.replace(':id', id);
        axios.delete(url)
            .then(function(response) {
                let successMessage = 'Guard deleted successfully';
                displaySuccess(successMessage);
                //refresh page
                setTimeout(function() {
                    location.reload();
                }, 2000);
            })
            .catch(function(error) {
                console.log(error);
                let errorMessage = error.response.data.message ? error.response.data.message :
                    'An error occured. Please try again';
                displayError(errorMessage);
            })
    }

    function AssignGuardToSite() {
        $('#assignSiteGuardModal').modal('show');
        //on submit
        $('#assignSiteGuardModal').on('submit', function(e) {
            e.preventDefault();
            let guard_id = $('#guard_id').val();
            let site_id = $('#site_id').val();
            var formData = {
                guard_id: guard_id,
                site_id: site_id
            };
            let url = `{{ route('admin.assignGuardToSite') }}`;
            axios({
                    method: 'POST',
                    url: url,
                    data: formData
                })
                .then(function(response) {
                    let successMessage = 'Guard assigned to site successfully';
                    displaySuccess(successMessage);
                    $('#assignSiteGuard').modal('hide');

                    //clear form
                    clearForm();

                    //refresh page
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                })
                .catch(function(error) {
                    console.log(error);
                    let errorMessage = error.response.data.message ? error.response.data.message :
                        'An error occured. Please try again';
                    displayError(errorMessage);
                });
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('.custom-select').select2();

        $('.custom-select').on('change', function(e) {
            @this.set($(this).attr('name'), e.target.value);
        });
    });
</script>
