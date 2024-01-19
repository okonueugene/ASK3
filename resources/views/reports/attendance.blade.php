@extends('admin.layouts.layout')
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Attendance Reports</h3>
                            <div class="nk-block-des text-soft">
                                {{-- <p>You have total 2,595 visitors.</p> --}}
                            </div>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="javascript: void(0)" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                    data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>

                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        @if ($filters)
                                            <li>
                                                <a href="javascript: void(0)" wire:click="exportAttendance"
                                                    wire:loading.attr="disabled"
                                                    class="btn btn-white btn-outline-light"><em
                                                        class="icon ni ni-download-cloud"></em><span>Export</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div><!-- .toggle-wrap -->
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between d-flex justify-space-between">
                        <div class="d-flex justify-content-between">
                            <div class="filters d-flex justify-content-between">
                                @if (auth()->user()->user_type == 'admin')
                                    <div class="form-group">
                                        <label class="form-label">Filter By Site</label>
                                        <div class="form-control-wrap mr-2">
                                            <select wire:model="selectedSite" class="form-control">
                                                <option selected>Choose Site</option>
                                                @foreach ($sites as $site)
                                                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                @if (auth()->user()->user_type == 'client' || !is_null($selectedSite))
                                    <div class="form-group mr-2">
                                        <label class="form-label">Filter By Guard</label>
                                        <div class="form-control-wrap">
                                            <select wire:model="selectedGuard" class="form-control" name="city_id">
                                                <option value="" selected>Choose Guard</option>
                                                @foreach ($guards as $guard)
                                                    <option value="{{ $guard->id }}">{{ $guard->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group"> <label class="form-label">Filter By Date</label>
                                    <div class="form-control-wrap">
                                        <div class="input-daterange date-picker-range input-group"> <input
                                                wire:model="start" type="text" class="form-control start-date" />
                                            <div class="input-group-addon">TO</div> <input wire:model="end"
                                                type="text" class="form-control end-date" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <button wire:click="filterRecords" class="btn btn-sm btn-secondary">
                                    Filter Records</button>
                                <button wire:click="resetFilter" class="btn btn-sm btn-outline-secondary">Reset
                                    Filters</button>
                            </div><!-- .toggle-wrap -->
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="card-title-group">
                                    <div class="card-tools">
                                        <div class="form-inline flex-nowrap gx-3">
                                            {{-- <div class="form-wrap w-150px">
                                                <select class="form-select" data-search="off"
                                                    data-placeholder="Bulk Action">
                                                    <option value="">Bulk Action</option>
                                                    <option value="email">Delete</option>
                                                </select>
                                            </div> --}}
                                            <div class="btn-wrap">
                                                <span class="d-none d-md-block"></span>
                                                <span class="d-md-none"><button
                                                        class="btn btn-dim btn-outline-light btn-icon disabled"><em
                                                            class="icon ni ni-arrow-right"></em></button></span>
                                            </div>
                                        </div><!-- .form-inline -->
                                    </div><!-- .card-tools -->
                                    <div class="card-tools mr-n1">
                                        <ul class="btn-toolbar gx-1">
                                            <li>
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-right">
                                                        <em class="icon ni ni-search"></em>
                                                    </div>
                                                    <input wire:model="search" type="text" class="form-control"
                                                        id="default-04" placeholder="Quick search by Name">
                                                </div>
                                            </li><!-- li -->
                                            <li class="btn-toolbar-sep"></li><!-- li -->
                                            <li>
                                                <div class="toggle-wrap">
                                                    <a href="javascript: void(0)"
                                                        class="btn btn-icon btn-trigger toggle"
                                                        data-target="cardTools"><em
                                                            class="icon ni ni-menu-right"></em></a>
                                                    <div class="toggle-content" data-content="cardTools">
                                                        <ul class="btn-toolbar gx-1">
                                                            <li class="toggle-close">
                                                                <a href="javascript: void(0)"
                                                                    class="btn btn-icon btn-trigger toggle"
                                                                    data-target="cardTools"><em
                                                                        class="icon ni ni-arrow-left"></em></a>
                                                            </li><!-- li -->
                                                            {{-- <li>
                                                                <div class="dropdown">
                                                                    <a href="#"
                                                                        class="btn btn-trigger btn-icon dropdown-toggle"
                                                                        data-toggle="dropdown">
                                                                        <div class="dot dot-primary"></div>
                                                                        <em class="icon ni ni-filter-alt"></em>
                                                                    </a>
                                                                    <div
                                                                        class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                                        <div class="dropdown-head">
                                                                            <span
                                                                                class="sub-title dropdown-title">Filter
                                                                                Records</span>
                                                                            <div class="dropdown">
                                                                                <a href="#"
                                                                                    class="btn btn-sm btn-icon">
                                                                                    <em class="icon ni ni-more-h"></em>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown-body dropdown-body-rg">
                                                                            <div class="row gx-6 gy-3">
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="overline-title overline-title-alt">Role</label>
                                                                                        <select class="form-select">
                                                                                            <option value="any">Any
                                                                                                Role</option>
                                                                                            <option value="investor">
                                                                                                Investor</option>
                                                                                            <option value="seller">
                                                                                                Seller</option>
                                                                                            <option value="buyer">Buyer
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="overline-title overline-title-alt">Status</label>
                                                                                        <select class="form-select">
                                                                                            <option value="any">Any
                                                                                                Status</option>
                                                                                            <option value="active">
                                                                                                Active</option>
                                                                                            <option value="pending">
                                                                                                Pending</option>
                                                                                            <option value="suspend">
                                                                                                Suspend</option>
                                                                                            <option value="deleted">
                                                                                                Deleted</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary">Filter</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown-foot between">
                                                                            <a class="clickable" href="#">Reset
                                                                                Filter</a>
                                                                            <a href="#">Save Filter</a>
                                                                        </div>
                                                                    </div><!-- .filter-wg -->
                                                                </div><!-- .dropdown -->
                                                            </li><!-- li --> --}}
                                                            <li>
                                                                <div class="dropdown">
                                                                    <a href="javascript: void(0)"
                                                                        class="btn btn-trigger btn-icon dropdown-toggle"
                                                                        data-toggle="dropdown">
                                                                        <em class="icon ni ni-setting"></em>
                                                                    </a>
                                                                    <div
                                                                        class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                                        <ul class="link-check">
                                                                            <li><span>Show</span></li>
                                                                            <li
                                                                                class="{{ $pages == 10 ? 'active' : '' }}">
                                                                                <a href="javascript: void(0)"
                                                                                    wire:click.prevent="$set('pages', 10)">10
                                                                                </a>
                                                                            </li>
                                                                            <li
                                                                                class="{{ $pages == 20 ? 'active' : '' }}">
                                                                                <a href="javascript: void(0)"
                                                                                    wire:click.prevent="$set('pages', 20)">20
                                                                                </a>
                                                                            </li>
                                                                            <li
                                                                                class="{{ $pages == 50 ? 'active' : '' }}">
                                                                                <a href="javascript: void(0)"
                                                                                    wire:click.prevent="$set('pages', 50)">50
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                        <ul class="link-check">
                                                                            <li><span>Order</span></li>
                                                                            <li
                                                                                class="{{ $order == 'DESC' ? 'active' : '' }}">
                                                                                <a href="javascript: void(0)"
                                                                                    wire:click.prevent="$set('order', 'DESC')">DESC</a>
                                                                            </li>
                                                                            <li
                                                                                class="{{ $order == 'ASC' ? 'active' : '' }}">
                                                                                <a
                                                                                    href="javascript: void(0)"wire:click.prevent="$set('order', 'ASC')">ASC</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div><!-- .dropdown -->
                                                            </li><!-- li -->
                                                        </ul><!-- .btn-toolbar -->
                                                    </div><!-- .toggle-content -->
                                                </div><!-- .toggle-wrap -->
                                            </li><!-- li -->
                                        </ul><!-- .btn-toolbar -->
                                    </div><!-- .card-tools -->
                                </div><!-- .card-title-group -->

                            </div><!-- .card-inner -->
                            <div class="card-inner p-0">
                                <div class="nk-tb-list nk-tb-ulist is-compact">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col nk-tb-col-check">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input" id="uid">
                                                <label class="custom-control-label" for="uid"></label>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col"><span class="sub-text">Name</span></div>
                                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Site</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span class="sub-text">Date</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Time In</span></div>
                                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Time Out</span></div>
                                        @if (auth()->user()->user_type == 'admin')
                                            <div class="nk-tb-col nk-tb-col-tools text-right">
                                                <div class="dropdown">
                                                    <a href="javascript: void(0)"
                                                        class="btn btn-xs btn-outline-light btn-icon dropdown-toggle"
                                                        data-toggle="dropdown" data-offset="0,5"><em
                                                            class="icon ni ni-plus"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                        <ul class="link-tidy sm no-bdr">
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-sm custom-checkbox">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input" checked=""
                                                                        id="ph">
                                                                    <label class="custom-control-label"
                                                                        for="ph">Phone</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div><!-- .nk-tb-item -->
                                    @foreach ($records as $record)
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="uid1">
                                                    <label class="custom-control-label" for="uid1"></label>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col">
                                                <div class="user-card">
                                                    <div class="user-avatar xs bg-primary">
                                                        <span>
                                                            <?php
                                                            $name = $record->owner->name;
                                                            preg_match_all('/\b\w/', $name, $name);
                                                            echo strtoupper(join('', $name[0])); ?>
                                                        </span>
                                                    </div>
                                                    <div class="user-name">
                                                        <span class="tb-lead">{{ $record->owner->name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-md">
                                                <span>{{ $record->owner->site->name ?? 'No Site' }}</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm">
                                                <span>{{ $record->day }}</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-md">
                                                <span>{{ $record->time_in }}</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-md">
                                                <span>{{ $record->time_out }} <span
                                                        class="ml-2 badge badge-success"><?php
                                                        if ($record->time_out) {
                                                            $start = Carbon\Carbon::parse($record->time_in);
                                                            $end = Carbon\Carbon::parse($record->time_out);
                                                            $diff = $end->diffInMinutes($start) / 60;
                                                            $final = number_format($diff, 2);
                                                            echo "$final Hours";
                                                        }
                                                        ?></span>
                                                </span>
                                            </div>
                                            @if (auth()->user()->user_type == 'admin')
                                                <div class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-2">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="javascript: void(0)"
                                                                    class="btn btn-sm btn-icon btn-trigger dropdown-toggle"
                                                                    data-toggle="dropdown"><em
                                                                        class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="javascript: void(0)"><em
                                                                                    class="icon ni ni-eye"></em><span>Edit
                                                                                </span></a></li>
                                                                        <li><a href="javascript: void(0)"><em
                                                                                    class="icon ni ni-na"></em><span>Delete
                                                                                </span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div><!-- .nk-tb-item -->
                                    @endforeach
                                </div><!-- .nk-tb-list -->
                            </div><!-- .card-inner -->
                            <div class="card-inner">
                                <ul class="pagination justify-content-center justify-content-md-start">
                                    {{ $records->links() }}
                                </ul><!-- .pagination -->
                            </div><!-- .card-inner -->
                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.custom-select').select2();
            $('.custom-select').on('change', function(e) {
                @this.set('selectedSite', e.target.value);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.start-date').datepicker({
                format: 'yy-mm-dd'
            });
            $('.start-date').on('change', function(e) {
                @this.set('start', e.target.value);
            });
        });
        $(document).ready(function() {
            $('.end-date').datepicker({
                format: 'yy-mm-dd',
            });
            $('.end-date').on('change', function(e) {
                @this.set('end', e.target.value);
            });
        });
    </script>
@endpush

@endsection