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
                                                    data-bs-target="#addClientModal"><em
                                                        class="icon ni ni-upload-cloud"></em><span>Add Client</span></a>
                                            </li>
                                            <li><a href="javascript:void(0)"
                                                    class="btn btn-white btn-dim btn-outline-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#inviteClientModal"><em
                                                        class="icon ni ni-upload-cloud"></em><span>Invite Client</span></a>
                                            </li>
                                        </ul>
                                    </div><!-- .toggle-expand-content -->
                                </div><!-- .toggle-wrap -->
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="card" style="margin-bottom: 20px;">
                        <div class="card-bordered">
                            <div id="accordion-1" class="accordion accordion-s2">
                                <div class="accordion-item">
                                    <a href="#" class="accordion-head" data-bs-toggle="collapse"
                                        data-bs-target="#accordion-item-1-1">
                                        <h6 class="title">Invitations</h6>
                                        <span class="accordion-icon"></span>
                                    </a>
                                    <div class="accordion-body collapse" id="accordion-item-1-1"
                                        data-bs-parent="#accordion-1">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Email</th>
                                                    <th>Sent By</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($invitations) > 0)
                                                    @foreach ($invitations as $invitation)
                                                        <tr>
                                                            <td>{{ $invitation->email }}</td>
                                                            <td>{{ $invitation->user->name }}</td>
                                                            <td>
                                                                @if ($invitation->is_accepted == 1)
                                                                    <span class="tb-status text-success">Accepted</span>
                                                                @else
                                                                    <span class="tb-status text-danger">Pending</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('delete-invitation', ['id' => $invitation->id]) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                                        onclick="return confirm('Are you sure you want to delete this invitation?')">Delete</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" class="text-center">
                                                            <h5>No Invitations Found</h5>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                @if (count($clients) > 0)
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col nk-tb-col-check">
                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                        <input type="checkbox" class="custom-control-input" id="uid">
                                                        <label class="custom-control-label" for="uid"></label>
                                                    </div>
                                                </th>
                                                <th class="nk-tb-col"><span class="sub-text">Client Name</span></th>
                                                <th class="nk-tb-col tb-col-mb"><span class="sub-text">Email</span></th>
                                                <th class="nk-tb-col tb-col-md"><span class="sub-text">Site</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Action</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($clients as $client)
                                                <tr>
                                                    <td class="nk-tb-col">
                                                        <div
                                                            class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="uid1">
                                                            <label class="custom-control-label" for="uid1"></label>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">
                                                            <div class="user-avatar bg-primary">
                                                                <span>{{ $client->name[0] }}</span>
                                                            </div>
                                                            <div class="user-info">
                                                                <span class="tb-lead">{{ $client->name }} <span
                                                                        class="dot dot-success d-md-none ml-1"></span></span>
                                                                <span>{{ $client->email }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-mb">
                                                        <span>{{ $client->email }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span>{{ $client->site->name ?? 'N/A' }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        @if ($client->is_active == 1)
                                                            <span class="tb-status text-success">Active</span>
                                                        @else
                                                            <span class="tb-status text-danger">Inactive</span>
                                                        @endif
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
                                                                                    onclick="editClient({{ $client->id }})">
                                                                                    <em class="icon ni ni-edit"></em>
                                                                                    <span>Edit Client</span>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                @if ($client->is_active == 0)
                                                                                    <a href="javascript:void(0)"
                                                                                        onclick="changeClientStatus({{ $client->id }})">
                                                                                        <em class="icon ni ni-check"></em>
                                                                                        <span>Activate Client</span>
                                                                                    </a>
                                                                                @else
                                                                                    <a href="javascript:void(0)"
                                                                                        onclick="changeClientStatus({{ $client->id }})">
                                                                                        <em class="icon ni ni-na"></em>
                                                                                        <span>Deactivate Client</span>
                                                                                    </a>
                                                                                @endif
                                                                            <li>
                                                                                @if ($client->site)
                                                                                    <a href="javascript:void(0)"
                                                                                        onclick="disassociateSiteFromClient({{ $client->id }})">
                                                                                        <em class="icon ni ni-na"></em>
                                                                                        <span>Disassociate
                                                                                            Site
                                                                                        </span>
                                                                                    </a>
                                                                                @else
                                                                                    <a href="javascript:void(0)"
                                                                                        onclick="assignSiteToClient({{ $client->id }})">
                                                                                        <em class="icon ni ni-plus"></em>
                                                                                        <span>Associate
                                                                                            Site
                                                                                        </span>
                                                                                    </a>
                                                                                @endif
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:void(0)"
                                                                                    onclick="deleteSite({{ $client->id }})">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                    <span>
                                                                                        Delete
                                                                                        Client
                                                                                    </span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr><!-- .nk-tb-item  -->
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <table class="table text-center">
                                        <tr>
                                            <td class="nk-tb-col">
                                                <span>No Records Found</span>
                                            </td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
    <!-- content @e -->
    <div class="modal fade" id="inviteClientModal" tabindex="-1" aria-labelledby="addClientModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Invite A Client</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="inviteClientForm" action="{{ route('client-invitation') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" name="name" placeholder="Client Name">
                            </div>
                        </div>
                        @error('name')
                            <div class="form-group">
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control" name="email" placeholder="Client Email">
                            </div>
                        </div>

                        @error('email')
                            <div class="form-group">
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Invite
                                Client</button>
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
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add A Client</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="addClientForm" action="{{ route('admin.addClient') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Client Name">
                            </div>
                        </div>
                        @error('name')
                            <div class="form-group">
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Client Email">
                            </div>
                        </div>

                        @error('email')
                            <div class="form-group">
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror

                        <div class="form-group">
                            <label for="site" class="form-label">Password</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Client Password">
                            </div>
                        </div>
                        @error('password')
                            <div class="form-group">
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror

                        <div class="form-group">
                            <label for="site" class="form-label">Repeat Password</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Repeat Client Password">
                            </div>
                        </div>

                        @error('password_confirmation')
                            <div class="form-group">
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror

                        <div class="form-group">
                            <button type="button" class="btn btn-md btn-primary" onclick="submitForm()">Add
                                Client</button>
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
    <!-- content @e -->
    <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Edit A Client</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="editClientForm">
                        <div class="form-control">
                            <label for="name" class="form-label">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="edit_name">
                            </div>
                        </div>
                        <div class="form-control">
                            <label for="email" class="form-label">Email</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control" id="edit_email">
                            </div>
                        </div>
                        <div class="form-control">
                            <label for="password" class="form-label">Password</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control" id="edit_password">
                            </div>
                        </div>
                        <div class="form-control">
                            <label for="password_confirmation" class="form-label">Repeat Password</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control" id="edit_password_confirmation">
                            </div>
                        </div>
                        <div class="form-control">
                            <button type="submit" class="btn btn-md btn-primary">Edit
                                Client</button>
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
    <div class="modal fade" id="assignSiteClientModal" tabindex="-1" aria-labelledby="assignSiteClientExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Assign Client To Site</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="assignSiteClientForm">
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
                                Client</button>
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    // Check if the password and confirm password match
    function checkPassword() {
        if (document.getElementById('password').value == document.getElementById('password_confirmation').value) {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'Password Match';
        } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Password Does Not Match';
        }
    }

    // Custom form submission function
    function submitForm() {
        // Check if passwords match
        if (document.getElementById('password').value == document.getElementById('password_confirmation').value) {
            // If match, submit the form and close the modal
            document.getElementById('addClientForm').submit();
            $('#addClientModal').modal('hide');
        } else {
            // If passwords don't match, display an error or take necessary action
            alert('Passwords do not match. Please check.');
        }
    }

    async function editClient(id) {
        const url = `{{ route('admin.getClient', ':id') }}`.replace(':id', id);
        const response = await axios.get(url);
        const client = response.data.client;

        // Set the values of the edit form
        document.getElementById('edit_name').value = client.name;
        document.getElementById('edit_email').value = client.email;

        // Leave password fields empty
        document.getElementById('edit_password').value = client.password;
        document.getElementById('edit_password_confirmation').value = client.password;

        // Show the modal
        $('#editClientModal').modal('show');

        // Submit the form
        $('#editClientForm').on('submit', function(e) {
            e.preventDefault();
            const url = `{{ route('admin.updateClient', ':id') }}`.replace(':id', id);
            const data = {
                name: document.getElementById('edit_name').value,
                email: document.getElementById('edit_email').value,
                password: document.getElementById('edit_password').value,
                password_confirmation: document.getElementById('edit_password_confirmation').value,
            };
            axios.patch(url, data)
                .then(function(response) {
                    if (response.data.status == 'success') {
                        displaySuccess(response.data.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        displayError(response.data.message);
                    }
                })
                .catch(function(error) {
                    displayError(error.response.data.message);
                });
        });
    }

    function changeClientStatus(id) {
        const url = `{{ route('admin.changeClientStatus', ':id') }}`.replace(':id', id);
        axios.put(url)
            .then(function(response) {
                if (response.data.status == 'success') {
                    displaySuccess(response.data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    displayError(response.data.message);
                }
            })
            .catch(function(error) {
                displayError(error.response.data.message);
            });
    }

    function assignSiteToClient(id) {
        //show the modal
        $('#assignSiteClientModal').modal('show');

        // Submit the form
        $('#assignSiteClientForm').on('submit', function(e) {
            e.preventDefault();
            const url = `{{ route('admin.assignSiteToClient', ':id') }}`.replace(':id', id);
            const data = {
                site_id: document.getElementById('site_id').value,
            };
            axios.patch(url, data)
                .then(function(response) {
                    if (response.data.status == 'success') {
                        displaySuccess(response.data.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        displayError(response.data.message);
                    }
                })
                .catch(function(error) {
                    displayError(error.response.data.message);
                });
        });

    }

    function disassociateSiteFromClient(id) {
        const url = `{{ route('admin.disassociateSiteFromClient', ':id') }}`.replace(':id', id);
        axios.put(url)
            .then(function(response) {
                if (response.data.status == 'success') {
                    displaySuccess(response.data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    displayError(response.data.message);
                }
            })
            .catch(function(error) {
                displayError(error.response.data.message);
            });
    }

    function deleteSite(id) {
        const url = `{{ route('admin.deleteClient', ':id') }}`.replace(':id', id);
        axios.delete(url)
            .then(function(response) {
                if (response.data.status == 'success') {
                    displaySuccess(response.data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    displayError(response.data.message);
                }
            })
            .catch(function(error) {
                displayError(error.response.data.message);
            });
    }
</script>
