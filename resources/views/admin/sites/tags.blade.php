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
                                                    <p>
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
                                                @if (count($tags) > 0)
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
                                                                <th class="nk-tb-col"><span class="sub-text">Name</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Type</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Code</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Location</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Action</span>
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($tags as $tag)
                                                                <tr>
                                                                    <td class="nk-tb-col">
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
                                                                            <div
                                                                                class="user-avatar bg-dim-primary d-none d-sm-flex">
                                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($tag->name) }}"
                                                                                    alt="">
                                                                            </div>
                                                                            <div class="user-info">
                                                                                <span
                                                                                    class="tb-lead">{{ $tag->name }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-mb">
                                                                        <span>{{ strtoupper($tag->type) }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-md">
                                                                        <span>{{ $tag->code }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-lg">
                                                                        <span>{{ $tag->location }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-md">
                                                                        <a href="javascript:void(0)"
                                                                            onclick="deleteTag({{ $tag->id }})"
                                                                            class="btn btn-sm btn-danger">
                                                                            Delete
                                                                        </a>
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
