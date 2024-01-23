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
                                    <button wire:click="filterRecords" class="btn btn-sm btn-outline-secondary">
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
                                <div class="card-inner p-0">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col nk-tb-col-check">
                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                        <input type="checkbox" class="custom-control-input" id="uid">
                                                        <label class="custom-control-label" for="uid"></label>
                                                    </div>
                                                </th>
                                                <th class="nk-tb-col"><span class="sub-text">Guard</span></th>
                                                <th class="nk-tb-col tb-col-mb"><span class="sub-text">Site</span></th>
                                                <th class="nk-tb-col tb-col-md"><span class="sub-text">Date</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Time In</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Time Out</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Total Hours</span>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($records as $record)
                                                <tr>
                                                    <td class="nk-tb-col">
                                                        <div
                                                            class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" class="custom-control-input"
                                                                wire:click="selectRecord({{ $record->id }})"
                                                                id="uid{{ $record->id }}">
                                                            <label class="custom-control-label"
                                                                for="uid{{ $record->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">
                                                            <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                                                <span>{{ $record->owner->name[0] }}</span>
                                                            </div>
                                                            <div class="user-info">
                                                                <span class="tb-lead">{{ $record->owner->name }} <span
                                                                        class="dot dot-success d-md-none ml-1"></span></span>
                                                                <span>{{ $record->owner->phone }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-mb">
                                                        <span>{{ $record->site->name }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span>{{ $record->day }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        <span>{{ $record->time_in }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        <span>{{ $record->time_out }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        @if($record->time_out)
                                                            <span>{{ diffInHours($record->time_in, $record->time_out) }}</span>
                                                        @else
                                                            <span class="text-danger">Not Available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No Records Found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div><!-- .card-inner -->
                            </div>

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
