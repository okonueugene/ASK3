@extends('admin.layouts.layout')
@section('content')
    <!-- content @s
                                -->
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

                                        </div><!-- .toggle-expand-content -->
                                    </div><!-- .toggle-wrap -->
                                </div><!-- .nk-block-head-content -->
                            </div><!-- .nk-block-between -->
                        </div><!-- .nk-block-head -->
                        <div class="nk-block">
                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    @if (count($incidents) > 0)
                                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                            <thead>
                                                <tr class="nk-tb-item nk-tb-head">
                                                    <th class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" class="custom-control-input" id="uid">
                                                            <label class="custom-control-label" for="uid"></label>
                                                        </div>
                                                    </th>
                                                    <th class="nk-tb-col"><span class="sub-text">Incident No</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Police Ref</span>
                                                    </th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Title</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Date</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Reported By</span>
                                                    </th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>

                                                    <th class="nk-tb-col nk-tb-col-tools text-right">
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($incidents as $incident)
                                                    <tr>
                                                        <td class="nk-tb-col nk-tb-col-check">
                                                            <div
                                                                class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="uid1">
                                                                <label class="custom-control-label" for="uid1"></label>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <div class="user-card">
                                                                <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                                                    <span>{{ $incident->incident_no }}</span>
                                                                </div>
                                                                <div class="user-info">
                                                                    <span class="tb-lead">{{ $incident->incident_no }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-mb">
                                                            <span>{{ $incident->police_ref }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $incident->title }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span>{{ $incident->date }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span>{{ $incident->reported_by }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span>{{ $incident->status }}</span>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-1">
                                                                <li>
                                                                    <div class="drodown">
                                                                        <a href="#"
                                                                            class="dropdown-toggle btn btn-icon btn-trigger"
                                                                            data-toggle="dropdown"><em
                                                                                class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li><a
                                                                                        href="{{ route('admin.incident.show', $incident->id) }}"><em
                                                                                            class="icon ni ni-eye"></em><span>View
                                                                                            Details</span></a></li>
                                                                                <li><a
                                                                                        href="{{ route('admin.incident.edit', $incident->id) }}"><em
                                                                                            class="icon ni ni-edit"></em><span>Edit
                                                                                            Details</span></a></li>
                                                                                <li><a
                                                                                        href="{{ route('admin.incident.destroy', $incident->id) }}"><em
                                                                                            class="icon ni ni-trash"></em><span>Delete</span></a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- content @e -->
    @endsection
