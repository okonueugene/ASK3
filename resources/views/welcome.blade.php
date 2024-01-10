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
                                            {{-- <ul class="nk-block-tools g-3">
                                                <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em
                                                            class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                                <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em
                                                            class="icon ni ni-reports"></em><span>Reports</span></a></li>
                                                <li class="nk-block-tools-opt">
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                                            data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#"><em
                                                                            class="icon ni ni-user-add-fill"></em><span>Add
                                                                            User</span></a></li>
                                                                <li><a href="#"><em
                                                                            class="icon ni ni-coin-alt-fill"></em><span>Add
                                                                            Order</span></a></li>
                                                                <li><a href="#"><em
                                                                            class="icon ni ni-note-add-fill-c"></em><span>Add
                                                                            Page</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul> --}}
                                        </div><!-- .toggle-expand-content -->
                                    </div><!-- .toggle-wrap -->
                                </div><!-- .nk-block-head-content -->
                            </div><!-- .nk-block-between -->
                        </div><!-- .nk-block-head -->
                        <div class="nk-block">
                            <div class="row g-gs">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content @e -->
    @endsection
