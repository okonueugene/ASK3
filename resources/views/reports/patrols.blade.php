@extends('admin.layouts.layout')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between d-flex justify-space-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Patrol Reports</h3>
                                <div class="nk-block-des text-soft">
                                    <p>You have {{ $total }} records.</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <div class="btn-group" aria-label="Basic example">
                                        <button type="button" wire:click="generateReport" wire:loading.attr="disabled"
                                            class="btn  btn-sm btn-outline-primary">PDF</button>
                                        <button type="button" wire:click="export('xlsx')" wire:loading.attr="disabled"
                                            class="btn btn-sm btn-outline-primary">XLSX</button>
                                        <button type="button" wire:click="export('csv')" wire:loading.attr="disabled"
                                            class="btn btn-sm btn-outline-primary">CSV</button>
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
                                    {{-- @if (auth()->user()->user_type == 'client' || !is_null($selectedSite)) --}}
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
                                    {{-- @endif --}}
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
                                                <div class="form-wrap w-150px">
                                                    {{-- <select class="form-select" data-search="off"
                                                            data-placeholder="Bulk Action">
                                                            <option value="">Bulk Action</option>
                                                            <option value="email">Delete</option>
                                                        </select> --}}
                                                </div>
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
                                                    <div class="form-control-wrap mb-3">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni ni-search"></em>
                                                        </div>
                                                        <input wire:model.debounce.350ms='search' type="text"
                                                            class="form-control" id="default-04"
                                                            placeholder="Search by Tag Name">
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

                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="javascript: void(0)"
                                                                            class="btn btn-trigger btn-icon dropdown-toggle"
                                                                            data-toggle="dropdown">
                                                                            <em class="icon ni ni-setting"></em>
                                                                        </a>
                                                                        <div
                                                                            class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                                            {{-- <ul class="link-check">
                                                                                    <li><span>Show</span></li>
                                                                                    <li
                                                                                        class="{{ $pages == 10 ? 'active' : '' }}">
                                                                                        <a href="javascript: void(0)"
                                                                                            wire:click.prevent="$set('pages', 10)">10</a>
                                                                                    </li>
                                                                                    <li
                                                                                        class="{{ $pages == 20 ? 'active' : '' }}">
                                                                                        <a href="javascript: void(0)"
                                                                                            wire:click.prevent="$set('pages', 20)">20</a>
                                                                                    </li>
                                                                                    <li
                                                                                        class="{{ $pages == 50 ? 'active' : '' }}">
                                                                                        <a href="javascript: void(0)"
                                                                                            wire:click.prevent="$set('pages', 50)">50</a>
                                                                                    </li>
                                                                                </ul> --}}
                                                                            {{-- <ul class="link-check">
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
                                                                                </ul> --}}
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
                                            <div class="nk-tb-col"><span class="sub-text">Shift</span></div>
                                            <div class="nk-tb-col tb-col-md"><span class="sub-text">Site</span></div>
                                            <div class="nk-tb-col tb-col-md"><span class="sub-text">Tag</span></div>
                                            <div class="nk-tb-col tb-col-sm"><span class="sub-text">Date</span></div>
                                            <div class="nk-tb-col tb-col-md"><span class="sub-text">Time</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        @forelse ($records as $record)
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
                                                            <span> <?php
                                                            $name = $record->owner->name;
                                                            preg_match_all('/\b\w/', $name, $name);
                                                            echo strtoupper(join('', $name[0]));
                                                            ?></span>
                                                        </div>
                                                        <div class="user-name">
                                                            <span class="tb-lead">{{ $record->patrol->owner->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span><span class="badge badge-warning">Not Yet
                                                        </span>
                                                        {{ $record->patrol->name }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span>{{ $record->site->name }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span>{{ $record->tag->name ? $record->tag->name : 'N/A' }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-sm">
                                                    <span>{{ $record->date }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    @if ($record->time)
                                                        <span>{{ $record->time }}</span>
                                                    @else
                                                        <span class="badge badge-white">No Scanned</span>
                                                    @endif
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    @if ($record->status == 'checked')
                                                        <span class="badge badge-success">Checked</span>
                                                    @elseif ($record->status == 'upcoming')
                                                        <span class="badge badge-dark">Upcoming</span>
                                                    @elseif($record->status == 'missed')
                                                        <span class="badge badge-danger">Missed</span>
                                                    @endif
                                                </div>
                                            </div><!-- .nk-tb-item -->
                                        @empty
                                            <div class="card-inner">
                                                <p class="text-center">No records found</p>
                                            </div>
                                        @endforelse
                                    </div><!-- .nk-tb-list -->
                                </div><!-- .card-inner -->
                                <div class="card-inner">
                                    {{-- <ul class="pagination justify-content-center justify-content-md-start">
                                            {{ $records->links() }}
                                        </ul><!-- .pagination --> --}}
                                </div><!-- .card-inner -->
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
@endsection
