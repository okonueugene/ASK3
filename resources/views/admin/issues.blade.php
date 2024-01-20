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
                                            <th class="nk-tb-col"><span class="sub-text">Title</span></th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Raised By</span>
                                            </th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Description</span>
                                            </th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                                            <th class="nk-tb-col nk-tb-col-tools text-right">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($issues) > 0)
                                            @foreach ($issues as $issue)
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
                                                                <span>{{ $issue->title[0] }}</span>
                                                            </div>
                                                            <div class="user-info">
                                                                <span class="tb-lead">{{ $issue->title }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-mb">
                                                        <span>{{ $issue->user->name }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-mb">
                                                        <span>{{ $issue->description }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span class="tb-status text-success">{{ $issue->status }}</span>
                                                    </td>
                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <li>
                                                                <div class="drodown">
                                                                    <a href="#"
                                                                        class="dropdown-toggle btn btn-sm btn-icon btn-trigger"
                                                                        data-toggle="dropdown"><em
                                                                            class="icon ni ni-more-h"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <ul class="link-list-opt no-bdr">
                                                                            <li><a
                                                                                    href="{{ route('admin.issues.show', $issue->id) }}"><em
                                                                                        class="icon ni ni-eye"></em><span>View
                                                                                        Details</span></a></li>
                                                                            <li><a
                                                                                    href="{{ route('admin.issues.edit', $issue->id) }}"><em
                                                                                        class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                            </li>
                                                                            <li><a
                                                                                    href="{{ route('admin.issues.destroy', $issue->id) }}"><em
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
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Issues Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-preview -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('.datatable-init').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 5]
                }]

            });
        });

    </script>