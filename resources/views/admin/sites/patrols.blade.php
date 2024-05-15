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
                                                            data-bs-toggle="modal" data-bs-target="#addPatrolModal">
                                                            <em class="icon ni ni ni-plus"></em>
                                                            <span>Scheduled Patrol</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
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
                                                                            id="uid">
                                                                        <label class="custom-control-label"
                                                                            for="uid"></label>
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
                                                                <th class="nk-tb-col"><span class="sub-text">Actions</span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($patrols as $patrol)
                                                                <tr class="nk-tb-item">
                                                                    <td class="nk-tb-col nk-tb-col-check">
                                                                        <div
                                                                            class="custom-control custom-control-sm custom-checkbox notext">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input" id="uid1">
                                                                            <label class="custom-control-label"
                                                                                for="uid1"></label>
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
                                                                                            <li>
                                                                                                {{-- <a href="{{ route('admin.patrol-edit', $patrol->id) }}" --}}
                                                                                                <a href="javascript:void(0)"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#editPatrolModal"
                                                                                                    onclick="editPatrol({{ $patrol }})">
                                                                                                    <em
                                                                                                        class="icon ni ni-edit"></em>
                                                                                                    <span>Edit Patrol</span>
                                                                                                </a>

                                                                                            </li>
                                                                                            <li>
                                                                                                {{-- <a href="{{ route('admin.patrol-delete', $patrol->id) }}" --}}
                                                                                                <a href="javascript:void(0)"
                                                                                                    onclick="deletePatrol({{ $patrol->id }})">
                                                                                                    <em
                                                                                                        class="icon ni ni-trash"></em>
                                                                                                    <span>Delete
                                                                                                        Patrol</span>
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
                    <form id="addSingleTagForm" action="{{ route('admin.addSingleTag', $site->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="full-name-1">Select
                                        Guard</label>
                                    <div class="form-control-wrap">
                                        <div class="form-group">
                                            <select class="custom-select form-select" data-search="on" id="guard_name">
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
                                        @foreach ($sitetags as $tag)
                                            <li>
                                                <div
                                                    class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                                                    <input type="checkbox" class="custom-control-input" name="tags[]"
                                                        id="{{ $tag->id }}"><label class="custom-control-label"
                                                        for="{{ $tag->id }}">{{ $tag->name == null ? $tag->code : $tag->location }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-md btn-primary float-end">Add Patrol</button>
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
                    <form id="editSingleTagForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="patrol_id" id="patrol_id">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" name="edit_name" id="edit_name"
                                    value="">
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="start" class="form-label">Start Time</label>
                            <div class="form-control-wrap">
                                <input type="time" class="form-control" name="edit_start" id="edit_start"
                                    value="">
                            </div>
                            @error('start')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="end" class="form-label">End Time</label>
                            <div class="form-control-wrap">
                                <input type="time" class="form-control" name="edit_end" id="edit_end"
                                    value="">
                            </div>
                            @error('end')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
    //Render checkpoit div if inputs are not empty
    window.onload = function() {
        $('#addSingleTagForm').on('input', function() {
            console.log($('#guard_name').val(), $('#round_name').val(), $('#start_time').val(), $(
                '#end_time').val());
            if ($('#guard_name').val() != '' && $('#round_name').val() != '' && $('#start_time').val() !=
                '' && $('#end_time').val() != '') {
                $('#checkpoint').show();
            } else {
                $('#checkpoint').hide();
            }
        });

        //Check All Checkpoints in the list 
        $('#checkAll').click(function() {
            if ($(this).is(':checked')) {
                $('input:checkbox').prop('checked', true);
            } else {
                $('input:checkbox').prop('checked', false);
            }
        });
    }

    function showPatrol(patrol) {
        $('#name').text(patrol.name);
        $('#guard').text(patrol.owner.name);
        $('#start').text(patrol.start);
        $('#end').text(patrol.end);
        patrol.type == 'scheduled' ? $('#type').text('Scheduled') : $('#type').text('Unscheduled');
    }

    function editPatrol(patrol) {
        $('#patrol_id').val(patrol.id);
        $('#edit_name').val(patrol.name);
        $('#edit_start').val(patrol.start);
        $('#edit_end').val(patrol.end);
    }
</script>
