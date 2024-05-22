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
                                    @if (count($sos) > 0)
                                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                            <thead>
                                                <tr class="nk-tb-item" style="background-color: #f4f5f9;">
                                                    <th class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" class="custom-control-input" id="uid">
                                                            <label class="custom-control-label" for="uid"></label>
                                                        </div>
                                                    </th>
                                                    <th class="nk-tb-col"><span class="sub-text">Guard</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Latitude</span>
                                                    </th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Longitude</span>
                                                    </th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Time</span></th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Duration</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sos as $sos)
                                                    <tr
                                                        class="nk-tb-item
                                                    @if ($sos->status == 'pending') bg-danger text-white
                                                    @else
                                                        bg-success text-white @endif

                                                    ">
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
                                                                <div class="user-avatar sm">
                                                                    <em class="icon ni ni">
                                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($sos->owner->name) }}"
                                                                            alt="">
                                                                    </em>
                                                                </div>
                                                                <div class="user-info">
                                                                    <span class="tb-lead">{{ $sos->owner->name }}</span>
                                                                    <span>{{ $sos->owner->phone }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-mb">
                                                            <span>{{ $sos->latitude }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $sos->longitude }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $sos->time }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $sos->created_at->diffForHumans() }}</span>
                                                        </td>
                                                    </tr><!-- .nk-tb-item -->
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            <div class="alert-text
                                            ">
                                                <h6 class="alert-title">No SOS Alerts</h6>
                                                <p class="mb-0">There are no SOS alerts at the moment.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div><!-- .card-preview -->
                        </div> <!-- nk-block -->
                    </div>
                </div>
            </div>
        </div>
        <!-- content @e -->
        </div>
        <!-- wrap @e -->
    @endsection
