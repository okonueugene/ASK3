@extends('admin.layouts.layout')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Dashboard</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Welcome to DashLite Dashboard Template.</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                        data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
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
                                        </ul>
                                    </div><!-- .toggle-expand-content -->
                                </div><!-- .toggle-wrap -->
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="row">
                            <div class="card-bodered card-preview mb-4">
                                <div id="map" class="card card-bordered google-map w-100"></div>
                            </div><!-- .card-preview -->
                        </div>
                        <div class="row g-gs">
                            <div class="col-md-6 col-xxl-4">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner border-bottom">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Notifications</h6>
                                            </div>
                                            <div class="card-tools">
                                                <a href="#" class="link">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner">
                                        <div class="timeline">
                                            <h6 class="timeline-head">{{ date("F j, Y") }}</h6>
                                            <ul class="timeline-list">
                                                @if(count($activities) > 0)
                                                @foreach($activities as $activity)
                                                <li class="timeline-item">
                                                    <div class="timeline-status bg-primary is-outline"></div>
                                                    <div class="timeline-date">
                                                        <span class="date">{{ $activity->created_at->format('d M') }}</span>
                                                        <em class="icon ni ni-alarm-alt"></em>
                                                    </div>
                                                    <div class="timeline-data">
                                                        <h6 class="timeline-title">{{ $activity->log_name }}</h6>
                                                        <div class="timeline-des">
                                                            <p>{{ $activity->description }}.</p>
                                                            <span class="time">{{ $activity->created_at->format('h:i A') }}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @else
                                                    <span style="margin-left: 20px;">No activities yet ... </span>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-xl-12 col-xxl-8">
                                <div class="card card-bordered card-full">
                                    <div class="card-inner border-bottom">
                                        <div class="card-title-group align-start mb-3">
                                            <div class="card-title">
                                                <h6 class="title">Overview</h6>
                                                <p>Today's Guards Attendance. <a
                                                        href="{{ route('admin.attendance-reports') }}"
                                                        class="link link-sm">Detailed Stats</a></p>
                                            </div>
                                            <div class="card-tools mt-n1 mr-n1">
                                                <div class="drodown">
                                                    <a href="javascript: void(0)"
                                                        class="dropdown-toggle btn btn-icon btn-trigger"
                                                        data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="javascript: void(0)" class="active"><span>15
                                                                        Days</span></a>
                                                            </li>
                                                            <li><a href="javascript: void(0)"><span>30 Days</span></a></li>
                                                            <li><a href="javascript: void(0)"><span>3 Months</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card-title-group -->
                                        <div class="nk-order-ovwg">
                                            <div class="row g-4 align-end">
                                                <div class="col-xxl-8">
                                                    <div class="nk-ck-sm">
                                                        <canvas id="polarChartData"></canvas>
                                                    </div>
                                                </div><!-- .col -->
                                                <div class="col-xxl-4">
                                                    <div class="row g-4">
                                                        <div class="col-sm-6 col-xxl-12">
                                                            <div class="nk-order-ovwg-data buy">
                                                                <div class="amount">{{ count($site) }}<small
                                                                        class="currenct currency-usd">Sites</small></div>
                                                                <div class="info">Sites under
                                                                    <strong>{{ Auth::user()->company->company_name }}
                                                                    </strong>
                                                                </div>
                                                                <div class="title"><em class="icon ni ni-location"></em>
                                                                    Total Sites </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-xxl-12">
                                                            <div class="nk-order-ovwg-data sell">
                                                                <div class="amount">{{ count($guards) }}<small
                                                                        class="currenct currency-usd"> Guards</small></div>
                                                                <div class="info">Total Guards
                                                                    <strong>{{ Auth::user()->company->company_name }}
                                                                    </strong>
                                                                </div>
                                                                <div class="title"><em class="icon ni ni-users"></em> Total
                                                                    Guards</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
@endsection

<script>
    // Google maps object for the map
    var map;
    // Array of markers
    var markers = [];
    // Info window
    var infowindow;
    // Array of locations
    var locations = [
        @foreach ($coordinates as $coordinate)
            ['{{ $coordinate->name }}', {{ $coordinate->lat }}, {{ $coordinate->long }}, {{ $coordinate->id }}],
        @endforeach
    ];

    function initMap() {
        // Create the map
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 9.5,
            center: new google.maps.LatLng({{ $coordinates->median('lat') }},
                {{ $coordinates->median('long') }}),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Create the info window
        infowindow = new google.maps.InfoWindow();

        // Create the markers
        for (var i = 0; i < locations.length; i++) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                title: locations[i][0],
                animation: google.maps.Animation.DROP
            });

            // Add the marker to the array
            markers.push(marker);

            // Add the click event to the marker
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    // Set the content of the info window
                    infowindow.setContent(locations[i][0]);
                    // Open the info window
                    infowindow.open(map, marker);
                    // Center the map to the clicked marker
                    map.setCenter(marker.getPosition());
                    // Go to the URL when title is clicked
                    google.maps.event.addListener(infowindow, 'domready', function() {
                        var clickableItem = document.querySelector('.gm-style-iw');
                        clickableItem.addEventListener('click', function() {
                            let value = locations[i][3];
                            let url = "{{ route('admin.site-overview', ':id') }}";
                            url = url.replace(':id', value);
                            window.location.href = url;
                        });
                    });
                }
            })(marker, i));
        }
    }

    // Function to center the map
    function centerMap() {
        // Create the bounds
        var bounds = new google.maps.LatLngBounds();

        // Loop through the markers and extend the bounds
        for (var i = 0; i < markers.length; i++) {
            bounds.extend(markers[i].getPosition());
        }

        // Center the map to the new bounds
        map.fitBounds(bounds);
    }

    // Call the initMap function and center the map
    window.onload = function() {
        centerMap();
    };
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('polarChartData').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Present Guards', 'Absent Guards'],
                datasets: [{
                    label: '# Guards',
                    data: [{{ count($present) }}, {{ count($guards) - count($present) }}],
                    backgroundColor: [
                        'rgba(12, 188, 69, 0.8)',
                        'rgba(251, 34, 0, 0.8)',
                    ],
                    borderColor: [
                        'rgba(12, 188, 69, 0.8)',
                        'rgba(251, 34, 0, 0.8)',
                    ],
                    borderWidth: 0.5
                }]
            }
        });
    });
</script>
@push('style')
    <style>
        #polarChartData {
            height: 300px !important;
        }

    </style>
@endpush