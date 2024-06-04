@extends('admin.layouts.layout')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-aside-wrap">
                                <div class="card-inner card-inner-lg">
                                    <div class="nk-block-head nk-block-head-lg">
                                        <div class="nk-block-between">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title">{{ $title }}</h4>
                                                <div class="nk-block-des">
                                                    <p>There are {{ count($guards) }} Guards posted in {{ $site->name }}.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="nk-block-head-content align-self-start d-lg-none"><a href="#"
                                                    class="toggle btn btn-icon btn-trigger mt-n1"
                                                    data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0)" style="display: none;"
                                            class="dropdown-toggle btn btn-icon btn-trigger float-end"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" data-bs-toggle="dropdown">
                                            <em class="icon ni ni-menu-alt-r"></em>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li>
                                                        <a href="javascript:void(0)" id="disassociateSelected">
                                                            <em class="icon ni ni-trash"></em>
                                                            <span>Disassociate Selected</span>
                                                        </a>

                                                    </li>
                                                </ul>

                                            </div>
                                        </a>
                                    </div>
                                    <div class="nk-block">
                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                                @if (count($guards) > 0)
                                                    <table class="datatable-init nk-tb-list nk-tb-ulist"
                                                        data-auto-responsive="false">
                                                        <thead>
                                                            <tr class="nk-tb-item nk-tb-head">
                                                                <th class="nk-tb-col nk-tb-col-check">
                                                                    <div
                                                                        class="custom-control custom-control-sm custom-checkbox notext">
                                                                        <input type="checkbox" class="custom-control-input"
                                                                            id="select-all">
                                                                        <label class="custom-control-label"
                                                                            for="select-all"></label>
                                                                    </div>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Name</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Phone</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Status</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Last
                                                                        Online</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Actions</span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($guards as $guard)
                                                                <tr>
                                                                    <td class="nk-tb-col">
                                                                        <div
                                                                            class="custom-control custom-control-sm custom-checkbox notext">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input item-checkbox"
                                                                                id="item-{{ $guard->id }}"
                                                                                value="{{ $guard->id }}">
                                                                            <label class="custom-control-label"
                                                                                for="item-{{ $guard->id }}"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="nk-tb-col">
                                                                        <div class="user-card">
                                                                            <div
                                                                                class="user-avatar bg-dim-primary d-none d-sm-flex">
                                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($guard->name) }}"
                                                                                    alt="{{ $guard->name }}">
                                                                            </div>
                                                                            <div class="user-info">
                                                                                <span class="tb-lead">{{ $guard->name }}
                                                                                    <span
                                                                                        class="dot dot-success d-md-none ml-1"></span></span>
                                                                                <span>{{ $guard->email }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-mb">
                                                                        <span>{{ $guard->phone }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-md">
                                                                        @if ($guard->is_active == 1)
                                                                            <span class="badge bg-success">Active</span>
                                                                        @else
                                                                            <span class="badge bg-warning">Inactive</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-md">
                                                                        <span>{{ $guard->last_login_at }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                                        <a href="javascript:void(0)"
                                                                            onclick="disassociateGuard({{ $guard->id }})"
                                                                            class="btn btn-round btn-icon btn-sm btn-outline-primary"><em
                                                                                class="icon ni ni-trash"></em></a>
                                                                    </td>
                                                                </tr>
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
                                        </div><!-- .card-preview -->
                                    </div>
                                </div>
                                @include('admin.commons.sidebar')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function disassociateGuard(id) {
        if (confirm('Are you sure you want to disassociate this guard from this site?')) {
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
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Select/Deselect all checkboxes
        const selectAllCheckbox = document.getElementById('select-all');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const selectedIds = new Set();
        // Function to update selected IDs
        function updateSelectedIds() {
            selectedIds.clear();
            itemCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedIds.add(checkbox.value);
                }

            });
            console.log(selectedIds);
            document.getElementById('dropdownMenuButton').style.display = 'block';

        }

        // Select/Deselect all checkboxes
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateSelectedIds();
            });
        }

        // Listen for changes on individual checkboxes
        if (itemCheckboxes) {
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    } else if (Array.from(itemCheckboxes).every(cb => cb.checked)) {
                        selectAllCheckbox.checked = true;
                    }
                    updateSelectedIds();
                });
            });
        }

        // Disassociate selected guards
        const disassociateSelected = document.getElementById('disassociateSelected');

        if (disassociateSelected) {
            disassociateSelected.addEventListener('click', function() {
                if (selectedIds.size === 0) {
                    displayError('Please select at least one guard to disassociate');
                    return;
                }
                if (confirm('Are you sure you want to disassociate the selected guards from this site?')) {
                    const ids = Array.from(selectedIds);
                    const url = `{{ route('admin.disassociateSelectedGuards', ':ids') }}`;
                    axios.put(url.replace(':ids', ids), {
                            ids: ids
                        })
                        .then(function(response) {
                            console.log(response.data);
                            displaySuccess('Selected guards disassociated successfully');
                            // Refresh page
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .catch(function(error) {
                            console.log(error);
                            const errorMessage = error.response.data.message ? error.response.data.message :
                                'An error occurred. Please try again';
                            displayError(errorMessage);
                        });
                        
                }
            });
        }

    });

</script>
