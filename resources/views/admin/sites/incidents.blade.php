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
                                                    <p>There are a total of {{ count($incidents) }} incidents recorded
                                                        for this site.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="nk-block-head-content align-self-start d-lg-none"><a href="#"
                                                    class="toggle btn btn-icon btn-trigger mt-n1"
                                                    data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-block">
                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                                @if (count($incidents) > 0)
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
                                                                <th class="nk-tb-col"><span class="sub-text">Incident
                                                                        NO</span></th>
                                                                <th class="nk-tb-col"><span class="sub-text">Title</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Status</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Date</span>
                                                                </th>
                                                                <th class="nk-tb-col nk-tb-col-tools text-end">Actions</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($incidents as $incident)
                                                                <tr class="nk-tb-item ">
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
                                                                        <span
                                                                            class="tb-lead">{{ $incident->incident_no }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col">
                                                                        <span class="tb-lead">{{ $incident->title }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col">
                                                                        <span
                                                                            class="tb-sub">{{ ucfirst($incident->status) }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col">
                                                                        <span class="tb-sub">{{ $incident->date }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                                        <ul class="nk-tb-actions gx-1">

                                                                            <li>
                                                                                <div class="drodown">
                                                                                    <a href="#"
                                                                                        class="dropdown-toggle btn btn-icon btn-trigger"
                                                                                        data-bs-toggle="dropdown"><em
                                                                                            class="icon ni ni-more-h"></em></a>
                                                                                    <div
                                                                                        class="dropdown-menu dropdown-menu-end">
                                                                                        <ul class="link-list-opt no-bdr">
                                                                                            <li>
                                                                                                <a href="javascript:void(0)"
                                                                                                    onclick="viewIncident({{ $incident }})"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#viewIncident"><em
                                                                                                        class="icon ni ni-eye"></em><span>View</span></a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <a href="javascript:void(0)"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#editIncident{{ $incident->id }}"><em
                                                                                                        class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <a href="javascript:void(0)"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#deleteIncident{{ $incident->id }}"><em
                                                                                                        class="icon ni ni-trash"></em><span>Delete</span></a>
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
    <div class="modal fade" id="viewIncident" tabindex="-1" aria-labelledby="viewIncidentModalExample" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Incident Details</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="nk-block">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label" for="incident_no">Incident No</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control form-control-lg">
                                                <span id="incident_no"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Title</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control form-control-lg">
                                                <span id="title"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label" for="details">Details</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control form-control-lg">
                                                <span id="details"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label" for="status">Status</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control form-control-lg">
                                                <span id="status"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label" for="date">Date</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control form-control-lg">
                                                <span id="date"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label" for="time">Time</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control form-control-lg">
                                                <span id="time"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label" for="reported_by">Reported By</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control form-control-lg">
                                                <span id="reported_by"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <ul id="mediaList">
                                            <!-- Media items will be dynamically added here -->
                                        </ul>
                                    </div>
                
                                    <br>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function viewIncident(incident) {
            $('#incident_no').text(incident.incident_no);
            $('#title').text(incident.title);
            $('#details').text(incident.details);
            $('#status').text(incident.status);
            $('#date').text(incident.date);
            $('#time').text(incident.time);
            $('#reported_by').text(incident.owner.name);

            if (incident.media.length > 0) {
                var mediaHtml = '<br><h6>Media:</h6><div class="media-container">';
                for (var i = 0; i < incident.media.length; i++) {
                    const regex = /http:\/\/localhost\/storage\//;
                    let media = incident.media[i].original_url.replace(regex, '');
                    // Pass the media through the asset helper
                    media = "{{ asset('storage') }}/" + media;

                    // Create a container for each media and its title
                    mediaHtml += '<div class="media-item">';
                    mediaHtml += '<img src="' + media + '" class="img-fluid" alt="img">';
                    mediaHtml += '<div class="media-title">Media ' + (incident.media[i].file_name) + '</div>';
                    mediaHtml += '</div>';
                }
                mediaHtml += '</div><br><br>'; // Add a line break between media groups
                $('#mediaList').html(mediaHtml);
            } else {
                $('#media').text('No media attached');
            }

        }
    </script>
