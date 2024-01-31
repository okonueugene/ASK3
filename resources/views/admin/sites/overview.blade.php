@extends('admin.layouts.layout')
@section('content')
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
                                        </div>

                                    </div>
                                </div>
                                <div class="nk-block">
                                    <div class="row">
                                        <div class="card card-bordered" id="sitemap" style="width: 100%; height: 170px;">
                                        </div>

                                    </div>
                                    <div class="row" id="summary">
                                        <div class="col-md-3">
                                            <div class="d-flex">
                                                <div class="user-avatar bg-success mr-3">
                                                    <span>{{ count($site->guards) }}</span>
                                                </div>
                                                <div class="fake-class mt-2">
                                                    <h6 class="mt-0 d-flex align-center"><span>Guards</span>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex border-dark">
                                                <div class="user-avatar bg-warning mr-3">
                                                    <span>{{ count($site->tags) }}</span>
                                                </div>
                                                <div class="fake-class mt-2">
                                                    <h6 class="mt-0 d-flex align-center"><span>Tour Tags</span>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex border-dark">
                                                <div class="user-avatar bg-dark mr-3">
                                                    <span>{{ count($site->patrols) }}</span>
                                                </div>
                                                <div class="fake-class mt-2">
                                                    <h6 class="mt-0 d-flex align-center"><span>Patrols</span>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex border-dark">
                                                <div class="user-avatar bg-info mr-3">
                                                    <span>{{ count($site->tasks) }}</span>
                                                </div>
                                                <div class="fake-class mt-2">
                                                    <h6 class="mt-0 d-flex align-center"><span>Tasks</span></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-gs">
                                    <div class="col-lg-6">
                                        <div class="card card-bordered card-full">
                                            <div class="card-header mb-4 border-bottom">
                                                <h6 class="title">Scheduled Events</h6>
                                            </div>
                                            @if (count($data['patrols']) > 0)
                                            <div class="nk-tb-list mt-n2">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col tb-col-md"><span>Round Name</span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-sm"><span>Guard</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>From</span></div>
                                                    <div class="nk-tb-col"><span class="d-none d-sm-inline">To</span>
                                                    </div>
                                                </div>
                                                @foreach ($data['patrols'] as $patrol)
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md">
                                                        <span class="tb-sub"></span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-sm">
                                                        <div class="user-card">
                                                            <div class="user-avatar sm bg-purple-dim">
                                                                {{-- <img src="https://ui-avatars.com/api/?name={{ urlencode($patrol->owner->name) }}"
                                                                    alt="data"> --}}
                                                            </div>
                                                            <div class="user-name">
                                                                {{-- <span class="tb-lead">{{ $patrol->owner->name }}</span> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        <span class="tb-sub">{{ $patrol->start }}</span>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        <span class="tb-sub">{{ $patrol->end }}</span>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="card-inner">
                                                <ul class="pagination justify-content-center justify-content-md-start">
                                                    {{ $data['patrols']->links() }}
                                                </ul><!-- .pagination -->
                                            </div><!-- .card-inner -->
                                            @else
                                            <div class="card-inner">
                                                <p class="text-center">No data avalailable</p>
                                            </div>
                                            @endif
                                        </div><!-- .card -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card card-bordered card-full">
                                            <div class="card-header mb-4 border-bottom">
                                                <div style="display:flex; justify-content:space-between !important; align-items:center"
                                                    class="d-flex justify-space-between">
                                                    <h6 class="title">Tasks</h6>
                                                    {{-- <a href="{{ route('client.client-tasks') }}" --}}
                                                        {{-- class="btn btn-secondary btn-sm">View Reports</a> --}}
                                                </div>
                                            </div>
                                            @if (count($data['tasks']) > 0)
                                            <div class="nk-tb-list mt-n2">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col tb-col-sm"><span>Guard</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                                    <div class="nk-tb-col"><span class="d-none d-sm-inline">Status</span>
                                                    </div>
                                                </div>
                                                @foreach ($data['tasks'] as $task)
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-sm">
                                                        <div class="user-card">
                                                            <div class="user-avatar sm bg-purple-dim">
                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($task->owner->name) }}"
                                                                    alt="data">
                                                            </div>
                                                            <div class="user-name">
                                                                <span class="tb-lead">{{ $task->owner->name }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        <span class="tb-sub">{{ $task->date }}</span>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        @if ($task->status === 'completed')
                                                        <span
                                                            class="badge badge-dot badge-dot-xs badge-success">Completed</span>
                                                        @else
                                                            <span class="badge badge-dot badge-dot-xs badge-danger">Not
                                                                Done</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="card-inner">
                                                <ul class="pagination justify-content-center justify-content-md-start">
                                                    {{ $data['tasks']->links() }}
                                                </ul><!-- .pagination -->
                                            </div><!-- .card-inner -->
                                            @else
                                            <div class="card-inner">
                                                <p class="text-center">No data avalailable</p>
                                            </div>
                                            @endif
                                        </div><!-- .card -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card card-bordered card-full">
                                            <div class="card-header mb-4 border-bottom">
                                                <div style="display:flex; justify-content:space-between !important; align-items:center"
                                                    class="d-flex justify-space-between">
                                                    <h6 class="title">DOBS</h6>
                                                    {{-- <a href="{{ route('client.client-dobs') }}" --}}
                                                        {{-- class="btn btn-secondary btn-sm">View
                                                        Reports</a> --}}
                                                </div>
                                            </div>
                                            @if (count($data['dobs']) > 0)
                                            <div class="nk-tb-list mt-n2">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col"><span>DOB No.</span></div>
                                                    <div class="nk-tb-col tb-col-sm"><span>Guard</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                                    <div class="nk-tb-col"><span class="d-none d-sm-inline">Duty
                                                            Start</span>
                                                    </div>
                                                </div>
                                                @foreach ($data['dobs'] as $dob)
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col">
                                                        <span class="tb-lead"><a
                                                                        href="#">#{{ $dob->dob_no }}</a></span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-sm">
                                                        <div class="user-card">
                                                            <div class="user-avatar sm bg-purple-dim">
                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($dob->owner->name) }}"
                                                                    alt="data">
                                                            </div>
                                                            <div class="user-name">
                                                                <span class="tb-lead">{{ $dob->owner->name }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        <span class="tb-sub">{{ $dob->date }}</span>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        <span class="tb-sub">{{ $dob->time_duty_start }}</span>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="card-inner">
                                                <ul class="pagination justify-content-center justify-content-md-start">
                                                    {{ $data['dobs']->links() }}
                                                </ul><!-- .pagination -->
                                            </div><!-- .card-inner -->
                                            @else
                                            <div class="card-inner">
                                                <p class="text-center">No data avalailable</p>
                                            </div>
                                            @endif
                                        </div><!-- .card -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card card-bordered card-full">
                                            <div class="card-header mb-4 border-bottom">
                                                <div style="display:flex; justify-content:space-between !important; align-items:center"
                                                    class="d-flex justify-space-between">
                                                    <h6 class="title">Incidents</h6>
                                                    {{-- <a href="{{ route('client.client-incidents') }}" --}}
                                                        {{-- class="btn btn-secondary btn-sm">View Reports</a> --}}
                                                </div>
                                            </div>
                                            @if (count($data['incidents']) > 0)
                                                <div class="nk-tb-list mt-n2">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <div class="nk-tb-col"><span>Incident No.</span></div>
                                                        <div class="nk-tb-col tb-col-sm"><span>Reported By</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                                        <div class="nk-tb-col"><span>Time</span></div>
                                                        <div class="nk-tb-col"><span
                                                                class="d-none d-sm-inline">Status</span>
                                                        </div>
                                                    </div>
                                                    @foreach ($data['incidents'] as $incident)
                                                        <div class="nk-tb-item">
                                                            <div class="nk-tb-col">
                                                                <span class="tb-lead"><a
                                                                        href="#">#{{ $incident->incident_no }}</a></span>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-sm">
                                                                <div class="user-card">
                                                                    <div class="user-avatar sm bg-purple-dim">
                                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($incident->owner->name) }}"
                                                                            alt="{{ $incident->owner->name }}">
                                                                    </div>
                                                                    <div class="user-name">
                                                                        <span
                                                                            class="tb-lead">{{ $incident->owner->name }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-md">
                                                                <span class="tb-sub">{{ $incident->date }}</span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <span
                                                                    class="tb-sub tb-amount">{{ $incident->time }}</span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <span
                                                                    class="badge badge-dot badge-dot-xs badge-success">{{ $incident->status }}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="card-inner">
                                                    <ul class="pagination justify-content-center justify-content-md-start">
                                                        {{ $data['incidents']->links() }}
                                                    </ul><!-- .pagination -->
                                                </div><!-- .card-inner -->
                                            @else
                                                <div class="card-inner">
                                                    <p class="text-center">No data avalailable</p>
                                                </div>
                                            @endif
                                        </div><!-- .card -->
                                    </div>
                                </div><!-- .row -->

                            </div>
                            @include('admin.commons.sidebar')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    #summary {
        position: relative;
        margin-top: 10px;
    }

    #summary .col-md-3 {
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        align-items: center;

    }
</style>

<script>
    //initilize the map using google map api
    async function initMap() {
        //set the center of the map
        var map = new google.maps.Map(document.getElementById('sitemap'), {
            center: {
                lat: 40.674,
                lng: -73.945
            },
            zoom: 12
        });
        //set the map bounds
        var bounds = new google.maps.LatLngBounds();
        //set the custom marker icon


        var marker = new google.maps.Marker({
            position: {
                lat: 40.674,
                lng: -73.945
            },
            map: map,
            title: 'Hello World!'
        });
        //extend the bounds to include each marker's position
        bounds.extend(marker.position);
        //now fit the map to the newly inclusive bounds

    }
</script>
