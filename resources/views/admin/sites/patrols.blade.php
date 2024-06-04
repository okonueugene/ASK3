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
                                                    <p>There are total of {{ $patrols->count() }} Patrols in this site.</p>
                                                </div>
                                            </div>
                                            <div class="nk-block-head-content">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-md btn-white btn-dim btn-outline-primary"
                                                            onclick="addPatrol()">
                                                            <em class="icon ni ni ni-plus"></em>
                                                            <span>Scheduled Patrol</span>
                                                        </a>
                                                    </li>
                                                </ul>
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
                                                        <a href="javascript:void(0)" id="bulk-delete">
                                                            <em class="icon ni ni-trash text-danger"></em>
                                                            <span>Delete Selected</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="nk-block">
                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                                @if (count($patrols) > 0)
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
                                                                <th class="nk-tb-col"><span class="sub-text">Guard</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Round
                                                                        Name</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Type</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Timing</span>
                                                                </th>
                                                                <th class="nk-tb-col nk-tb-col-tools text-end">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($patrols as $patrol)
                                                                <tr class="nk-tb-item">
                                                                    <td class="nk-tb-col nk-tb-col-check">
                                                                        <div
                                                                            class="custom-control custom-control-sm custom-checkbox notext">
                                                                             <input type="checkbox"
                                                                                class="custom-control-input item-checkbox"
                                                                                id="item-{{ $patrol->id }}"
                                                                                value="{{ $patrol->id }}"
                                                                             >
                                                                            <label class="custom-control-label"
                                                                                for="item-{{ $patrol->id }}"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="nk-tb-col">
                                                                        <div class="user-card">
                                                                            <div class="user-avatar bg-primary">
                                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($patrol->owner->name) }}"
                                                                                    alt="{{ $patrol->owner->name }}">
                                                                            </div>
                                                                            <div class="user-info">
                                                                                <span
                                                                                    class="tb-lead">{{ $patrol->owner->name }}</span>
                                                                                <span>{{ $patrol->owner->phone }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="nk-tb-col">
                                                                        <span
                                                                            class="tb-sub">{{ ucfirst($patrol->name) }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col">
                                                                        <span
                                                                            class="tb-sub">{{ ucfirst($patrol->type) }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col">
                                                                        <span
                                                                            class="tb-sub">{{ date('H:i', strtotime($patrol->start)) }}
                                                                            -
                                                                            {{ date('H:i', strtotime($patrol->end)) }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                                        <ul class="nk-tb-actions gx-1">

                                                                            <li>
                                                                                <div class="drodown">
                                                                                    <a href="#"
                                                                                        class="dropdown-toggle btn btn-icon btn-trigger"
                                                                                        data-bs-toggle="dropdown">
                                                                                        <em
                                                                                            class="icon ni ni-more-h"></em></a>
                                                                                    <div
                                                                                        class="dropdown-menu dropdown-menu-end">
                                                                                        <ul class="link-list-opt no-bdr">
                                                                                            <li>
                                                                                                {{-- <a href="{{ route('admin.patrol-show', $patrol->id) }}" --}}
                                                                                                <a href="javascript:void(0)"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#showPatrolModal"
                                                                                                    onclick="showPatrol({{ $patrol }})">
                                                                                                    <em
                                                                                                        class="icon ni ni-eye"></em>
                                                                                                    <span>Show Patrol</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            @if ($patrol->type == 'scheduled')
                                                                                                <li>
                                                                                                    {{-- <a href="{{ route('admin.patrol-edit', $patrol->id) }}" --}}
                                                                                                    <a href="javascript:void(0)"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#editPatrolModal"
                                                                                                        onclick="editPatrol({{ $patrol }})">

                                                                                                        <em
                                                                                                            class="icon ni ni-edit"></em>
                                                                                                        <span>Edit
                                                                                                            Patrol</span>
                                                                                                    </a>

                                                                                                </li>
                                                                                                <li>
                                                                                                    <form
                                                                                                        action="{{ route('admin.deletePatrol', $patrol->id) }}"
                                                                                                        method="POST">
                                                                                                        @csrf
                                                                                                        @method('DELETE')
                                                                                                        <button
                                                                                                            type="submit"
                                                                                                            class="btn btn-link text-danger"
                                                                                                            onclick="return confirm('Are you sure you want to delete this patrol?')">
                                                                                                            <em
                                                                                                                class="icon ni ni-trash"></em>
                                                                                                            <span>Delete</span>
                                                                                                        </button>
                                                                                                    </form>

                                                                                                </li>
                                                                                            @endif
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

    <div class="modal fade" id="addPatrolModal" tabindex="-1" aria-labelledby="addTagModalExample" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add Patrol</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="addPatrolForm" action="{{ route('admin.addPatrol', $site->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="full-name-1">Select
                                        Guard</label>
                                    <div class="form-control-wrap">
                                        <div class="form-group">
                                            <select class="custom-select form-select" data-search="on" id="guard_name"
                                                name="guard_id">
                                                <option>Select Guard</option>
                                                @foreach ($siteguards as $siteguard)
                                                    <option value="{{ $siteguard->id }}">
                                                        {{ $siteguard->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="name" class="form-label">Round Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="name" id="round_name"
                                            required>
                                    </div>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="start" class="form-label">Start Time</label>
                                    <div class="form-control-wrap">
                                        <input type="time" class="form-control" name="start" id="start_time"
                                            required>
                                    </div>
                                    @error('start')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="end" class="form-label">End Time</label>
                                    <div class="form-control-wrap">
                                        <input type="time" class="form-control" name="end" id="end_time"
                                            required>
                                    </div>
                                    @error('end')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id="checkpoint" style="display: none;">
                            <div class="card card-preview">
                                <div class="card-inner">
                                    <h6 class="title mb-3">Select Checkpoints</h6>
                                    <div><span><input type="checkbox" id="checkAll"> Check All</span></div>
                                    <ul class="custom-control-group">
                                        @foreach ($sitetags as $checkpoint)
                                            <li>
                                                <div
                                                    class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                                                    <input type="checkbox" class="custom-control-input checkpointItem"
                                                        id="checkpoint{{ $checkpoint->id }}"
                                                        value="{{ $checkpoint->id }}">
                                                    <label class="custom-control-label"
                                                        for="checkpoint{{ $checkpoint->id }}">{{ $checkpoint->name }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="tags[]" id="tags">
                        <input type="hidden" name="site_id" value="{{ $site->id }}">
                        <div class="form-group" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-md btn-primary float-end">Add Patrol</button>
                            <button type="button" class="btn btn-white btn-dim btn-outline-secondary float-end"
                                onclick="closePatrol()">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showPatrolModal" tabindex="-1" aria-labelledby="showPatrolModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Show Patrol</h5>

                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <div class="form-control form-control-lg">
                                <span id="name"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="guard" class="form-label">Guard</label>
                            <div class="form-control form-control-lg">
                                <span id="guard"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="start" class="form-label text-center">Start Time</label>
                            <div class="form-control form-control-lg">
                                <span id="start"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="end" class="form-label">End Time</label>
                            <div class="form-control form-control-lg">
                                <span id="end"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="type" class="form-label">Type</label>
                            <div class="form-control form-control-lg">
                                <span id="type"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="tags" class="form-label">Checkpoints</label>
                            <div class="form-control form-control-lg">
                                <ul id="show_tags" class="list-group list-group-numbered"></ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="button" class="btn btn-white btn-dim btn-outline-secondary float-end"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editPatrolModal" tabindex="-1" aria-labelledby="editPatrolModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Edit Patrol</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="editSingleTagForm" action="{{ route('admin.updatePatrol', $site->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="patrol_id" id="patrol_id">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" name="edit_name" id="edit_name"
                                    value="">
                            </div>
                            @error('edit_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="start" class="form-label">Start Time</label>
                            <div class="form-control-wrap">
                                <input type="time" class="form-control" name="edit_start" id="edit_start"
                                    value="">
                            </div>
                            @error('edit_start')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="end" class="form-label">End Time</label>
                            <div class="form-control-wrap">
                                <input type="time" class="form-control" name="edit_end" id="edit_end"
                                    value="">
                            </div>
                            @error('edit_end')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tags" class="form-label">Select Checkpoints</label>
                            <div id="edit_checkpoints">
                                <!-- Checkpoints will be populated here -->
                            </div>
                        </div>
                        <input type="hidden" name="tags" id="edit_tags">
                        <div class="form-group" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-md btn-primary float-end">Edit Patrol</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAll');
        const checkpointItems = document.querySelectorAll('.checkpointItem');

        function validateInput() {
            $('#addPatrolForm').on('input', function() {

                if ($('#guard_name').val() != '' && $('#round_name').val() != '' && $('#start_time')
                    .val() !=
                    '' && $('#end_time').val() != '') {
                    $('#checkpoint').show();
                }
            });
        }

        function handleSelectTags() {
            const tags = [];

            // Toggle checkbox states based on "Check All"
            checkpointItems.forEach(item => {
                item.checked = checkAll.checked;
            });

            // Update tags array based on currently checked items
            tags.length = 0;
            checkpointItems.forEach(item => {
                if (item.checked) {
                    tags.push(item.value);
                }
            });

            // Update the hidden input with the updated tags array
            $('#tags').val(tags);
        }

        // Attach event listener to "Check All" checkbox
        if (checkAll) {
            checkAll.addEventListener('change', handleSelectTags);
        }

        // Attach event listener to individual checkboxes
        if (checkpointItems) {
            checkpointItems.forEach(item => {
                item.addEventListener('change', handleSelectTags);
            });
        }


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

        document.getElementById('bulk-delete').addEventListener('click', function() {
            if (selectedIds.size > 0) {
                if (confirm('Are you sure you want to delete selected items?')) {
                    const url = "{{ route('admin.deleteMultiplePatrols', ':ids') }}";
                    const ids = Array.from(selectedIds).join(',');


                    axios.delete(url.replace(':ids', ids), {
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {
                                ids: Array.from(selectedIds)
                            }
                        })
                        .then(function(response) {
                            if (response.data.success) {
                                displaySuccess(response.data.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                displayError(response.data.error);
                                console.log(response.data);
                            }
                        })
                        .catch(function(error) {
                            displayError(error.response.data.error || 'An error occurred');
                            console.log(error.response.data);
                        });
                }
            } else {
                alert('No items selected');
            }
        });


    });

    function handleEditedSelectedTags() {
        const checkAll = document.getElementById('checkAll');
        const checkpointItems = document.querySelectorAll('.checkpointItem');
        const tags = [];

        // Check if "Check All" is selected
        if (checkAll.checked) {
            checkpointItems.forEach(item => {
                item.checked = true;
                tags.push(item.value);
            });
        } else {
            // Loop through individual checkboxes
            checkpointItems.forEach(item => {
                if (item.checked) {
                    tags.push(item.value);
                }
            });
        }

        //append the tags to the hidden input
        $('#edit_tags').val(tags);
    }

    function addPatrol() {
        $('#addPatrolModal').modal('show');
        //run the function to validate inputs
        setInterval(() => {
            validateInput();
        }, 1000);
        handleSelectTags();

    }

    function closePatrol() {
        $('#addPatrolModal').modal('hide');
        //reset the form
        $('#addPatrolForm').trigger('reset');
        //clear the interval
        clearInterval();
    }


    function showPatrol(patrol) {
        $('#name').text(patrol.name);
        $('#guard').text(patrol.owner.name);
        $('#start').text(patrol.start);
        $('#end').text(patrol.end);
        patrol.type == 'scheduled' ? $('#type').text('Scheduled') : $('#type').text('Unscheduled');

        if (patrol.tags) {
            let tagsHtml = '';
            patrol.tags.forEach(tag => {
                tagsHtml += `
          <li class="list-group-item">${tag.name ? tag.name : (tag.code ? tag.code : tag.location)}</li>
      `;
            });

            $('#show_tags').empty();
            $('#show_tags').append(tagsHtml);
        } else {
            // Handle case where patrol.tags is missing or empty (optional)
            $('#show_tags').text('No tags associated with this patrol.');
        }

        $('#showPatrolModal').modal('show');
    }

    function editPatrol(patrol) {
        document.getElementById('patrol_id').value = patrol.id;
        document.getElementById('edit_name').value = patrol.name;
        document.getElementById('edit_start').value = patrol.start;
        document.getElementById('edit_end').value = patrol.end;

        const siteTags = {!! json_encode($sitetags) !!};
        let checkpointsHtml = '';
        siteTags.forEach(tag => {
            const isChecked = patrol.tags.some(patrolTag => patrolTag.id === tag.id) ? 'checked' :
                '';
            checkpointsHtml += `
            <div class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                <input type="checkbox" class="custom-control-input checkpointItem" id="edit_checkpoint${tag.id}" value="${tag.id}" ${isChecked}>
                <label class="custom-control-label" for="edit_checkpoint${tag.id}">${tag.name}</label>
            </div>
        `;
        });
        document.getElementById('edit_checkpoints').innerHTML = checkpointsHtml;
        $('#editPatrolModal').modal('show');

        document.getElementById('editSingleTagForm').addEventListener('submit', function(e) {
            e.preventDefault();
            handleEditedSelectedTags();
            this.submit();
        });
    }
</script>
