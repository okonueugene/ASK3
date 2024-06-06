@extends('admin.layouts.layout')
@section('content')
    <!-- content -->
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title text-center">{{ $title }}</h3>
                                <div class="nk-block-des text-soft">
                                    {{-- <p>Welcome to DashLite Dashboard Template.</p> --}}
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                        data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li><a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#addSiteModal"
                                                    class="btn
                                                    btn-white btn-dim btn-outline-primary"><em
                                                        class="icon ni ni-upload-cloud"></em><span>Add Site</span></a>
                                            </li>
                                            <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em
                                                        class="icon ni ni-reports"></em><span>Reports</span></a></li>

                                        </ul>
                                    </div><!-- .toggle-expand-content -->
                                </div><!-- .toggle-wrap -->
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                @if (count($sites) > 0)
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col nk-tb-col-check">
                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                        <input type="checkbox" class="custom-control-input" id="uid">
                                                        <label class="custom-control-label" for="uid"></label>
                                                    </div>
                                                </th>
                                                <th class="nk-tb-col"><span class="sub-text">Name</span></th>
                                                <th class="nk-tb-col tb-col-mb"><span class="sub-text">Site Owner</span>
                                                </th>
                                                <th class="nk-tb-col tb-col-md"><span class="sub-text">Location</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Country</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>
                                                <th class="nk-tb-col tb-col-md"><span class="sub-text">Timezone</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-end">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($sites as $site)
                                                <tr class="nk-tb-item">
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
                                                                <span>
                                                                    @if ($site->media->count() == 0)
                                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($site->name) }}&color=f76b0e&background=ffffff"
                                                                            alt="{{ $site->name }}">
                                                                    @else
                                                                        <img src="{{ asset(str_replace('http://localhost', '', $site->media->first()->getUrl())) }}"
                                                                            alt="{{ $site->name }}">
                                                                    @endif
                                                                </span>

                                                            </div>
                                                            <div class="user-info">
                                                                <span class="tb-lead">{{ $site->name }}<span
                                                                        class="dot dot-success d-md-none ms-1"></span></span>
                                                                <span>info@softnio.com</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                                                        <span class="tb-amount">{{ $site->owner->name ?? 'N/A' }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span>{{ $site->location }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        <span>{{ $site->country }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        @if ($site->is_active == 1)
                                                            <span class="tb-status text-success">Active</span>
                                                        @else
                                                            <span class="tb-status text-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="nk-tb-col tb-col-md">
                                                        <span class="tb-amount">{{ $site->timezone }}</span>
                                                    </td>
                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">

                                                            <li>
                                                                <div class="drodown">
                                                                    <a href="#"
                                                                        class="dropdown-toggle btn btn-icon btn-trigger"
                                                                        data-bs-toggle="dropdown"><em
                                                                            class="icon ni ni-more-h"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <ul class="link-list-opt no-bdr">
                                                                            <li>
                                                                                <a href="javascript:void(0)"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#viewSiteModal"
                                                                                    onclick="quickView({{ $site->id }})">

                                                                                    <em class="icon ni ni-focus"></em>
                                                                                    <span>Quick View</span>
                                                                                </a>
                                                                            </li>
                                                                            <li><a
                                                                                    href="{{ route('admin.site-overview', $site->id) }}"><em
                                                                                        class="icon ni ni-eye"></em><span>View
                                                                                        Site</span></a></li>
                                                                            <li><a href="javascript:void(0)"
                                                                                    onclick="updateSite({{ $site->id }})"><em
                                                                                        class="icon ni ni-repeat"></em><span>Update
                                                                                        Site</span></a>
                                                                            </li>
                                                                            @if ($site->is_active == 1)
                                                                                <li>
                                                                                    <a href="javascript:void(0)"
                                                                                        onclick="suspendSite({{ $site->id }})">
                                                                                        <em class="icon ni ni-na"></em>
                                                                                        <span>Suspend Site</span>
                                                                                    </a>
                                                                                </li>
                                                                            @else
                                                                                <li>
                                                                                    <a href="javascript:void(0)"
                                                                                        onclick="suspendSite({{ $site->id }})">
                                                                                        <em class="icon ni ni-check"></em>
                                                                                        <span>Activate Site</span>
                                                                                    </a>
                                                                                </li>
                                                                            @endif
                                                                            <li><a href="javascript:void(0)"><em
                                                                                        class="icon ni ni-trash"></em><span>Remove
                                                                                        Site</span></a></li>
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
    <div class="modal fade" id="addSiteModal" tabindex="-1" aria-labelledby="addSiteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"> <a href="javascript:void(0)"class="close" onclick="closeModal()"
                    data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross"></em> </a>
                <div class="modal-header">
                    <h5 class="modal-title text-center">Add Site</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.addSite') }}" id="addSiteForm" class="form-validate is-alter"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="site-name">Site Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="name" name="name"
                                            required>
                                    </div>
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="site-address">Enter Site Location</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="location" name="location"
                                            required>
                                    </div>
                                    @error('location')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="site-country">Country</label>
                                    <div class="form-control-wrap">
                                        <select class="custom-select form-select" id="country" name="country" required>
                                            <option value="">Select Country</option>
                                            {{-- @foreach ($countries as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    @error('country')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="site-timezone">Timezone</label>
                                    <div class="form-control-wrap">
                                        <select class="custom-select form-select" id="timezone" name="timezone"
                                            required>
                                            <option value="">Select Timezone</option>
                                            {{-- @foreach ($timezones as $timezone)
                                                <option value="{{ $timezone }}">{{ $timezone }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    @error('timezone')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label" for="media-default">Site Logo</label>
                                <div class="form-control-wrap">
                                    <div class="custom-file">
                                        <input type="file" multiple class="custom-file-input" id="logo"
                                            name="logo" accept="image/*" required>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="latitude">Latitude</label>
                                    <input type="text" name="lat" id="lat" class="form-control"
                                        value="0" onchange="updateMap()" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="longitude">Longitude</label>
                                    <input type="text" name="long" id="long" class="form-control"
                                        value="0" onchange="updateMap()" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card card-bordered" id="address-map-container" style="width:100%;height:300px;">
                                <div style="width: 100%; height: 100%" id="address-map"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Save</button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer bg-light">
                    <span class="sub-text">AskariTechnologies {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- view site modal --->
    <div class="modal fade" id="viewSiteModal" tabindex="-1" aria-labelledby="viewSiteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"> <a href="javascript:void(0)"class="close" onclick="closeModal()"
                    data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross"></em> </a>
                <div class="modal-header text-center">
                    <h5 class="modal-title">View Site</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="logo" style="position: relative; top: 0; left: 0;">
                            <div id="map" style="height:100px;width:100%;"></div>
                            <div class="card-header text-center">
                                <span class="card-title" id="site-name"></span>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Site Owner: <span id="site-owner"></span></p>
                                <p class="card-text">Location: <span id="site-location"></span></p>
                                <p class="card-text">Country: <span id="site-country"></span></p>
                                <p class="card-text">Timezone: <span id="site-timezone"></span></p>
                                <p class="card-text">Status: <span id="site-status"></span></p>
                                <p class="card-text">Latitude: <span id="site-latitude"></span></p>
                                <p class="card-text">Longitude: <span id="site-longitude"></span></p>
                                <p class="card-text">Guards: <span id="site-guards"></span></p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <span class="sub-text">AskariTechnologies {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- update site modal --->
    <div class="modal fade" id="updateSiteModal" tabindex="-1" aria-labelledby="updateSiteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"> <a href="javascript:void(0)"class="close" onclick="closeModal()"
                    data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross"></em> </a>
                <div class="modal-header">
                    <h5 class="modal-title text-center">Update Site</h5>
                </div>
                <div class="modal-body">
                    <form id="updateSiteForm" lass="form-validate is-alter" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="site-name">Site Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="update-name" name="update-name"
                                            required>
                                    </div>
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="site-address">Enter Site Location</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="update-location"
                                            name="update-location" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="site-country">Country</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="update-country" name="update-country" required>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="site-timezone">Timezone</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="update-timezone" name="update-timezone" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label" for="media-default">Site Logo</label>
                                    <div class="form-control-wrap">
                                        <img id="current-logo" src="" alt="Current Logo"
                                            style="max-width: 100px; display: none;">
                                        <div class="custom-file">
                                            <input type="file" multiple class="custom-file-input" id="update-logo"
                                                name="update-logo" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-label" for="latitude">Latitude</label>
                                        <input type="text" name="update-lat" id="update-lat" class="form-control"
                                            value="0" onchange="updateMap()" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-label" for="longitude">Longitude</label>
                                        <input type="text" name="update-long" id="update-long" class="form-control"
                                            value="0" onchange="updateMap()" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="card card-bordered" id="address-map-container"
                                        style="width:100%;height:300px;">
                                        <div style="width: 100%; height: 100%" id="update-address-map"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                </div>
                            </div>
                    </form>

                </div>
                <div class="modal-footer bg-light">
                    <span class="sub-text">AskariTechnologies {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function closeModal() {
        $('#addSiteModal').modal('hide');
        $('#viewSiteModal').modal('hide');
        $('#updateSiteModal').modal('hide');
    }
</script>

<script>
    //clear input fields
    function clearInputFields() {
        $('#name').val('');
        $('#location').val('');
        $('#country').val('');
        $('#timezone').val('');
        $('#logo').val('');
        $('#lat').val('');
        $('#long').val('');
        $('#site-name').text('');
        $('#site-owner').text('');
        $('#site-location').text('');
        $('#site-country').text('');
        $('#site-timezone').text('');
        $('#site-status').text('');
        $('#site-latitude').text('');
        $('#site-longitude').text('');
        $('#site-logo').attr('src', '');
    }

    window.addEventListener('load', clearInputFields);
</script>
<script>
    // Initialize map
    var map;
    var marker;

    function initMap() {
        var initialLat = parseFloat($('#lat').val());
        var initialLng = parseFloat($('#long').val());
        // Check if the coordinates are valid numbers
        if (isNaN(initialLat) || isNaN(initialLng)) {
            initialLat = 0;
            initialLng = 0;
        }

        map = new google.maps.Map(document.getElementById('address-map'), {
            center: {
                lat: initialLat,
                lng: initialLng
            },
            zoom: 15
        });

        marker = new google.maps.Marker({
            position: {
                lat: initialLat,
                lng: initialLng
            },
            map: map,
            draggable: true
        });

        // Update the latitude and longitude inputs when the marker is dragged
        marker.addListener('dragend', function(event) {
            $('#lat').val(event.latLng.lat());
            $('#long').val(event.latLng.lng());
        });
    }

    function updateMap() {
        var lat = parseFloat($('#lat').val());
        var lng = parseFloat($('#long').val());

        // Update the map center and marker position
        map.setCenter({
            lat: lat,
            lng: lng
        });
        marker.setPosition({
            lat: lat,
            lng: lng
        });
    }
    window.addEventListener('load', initMap);
</script>



<script>
    async function quickView(id) {
        let url = `{{ route('admin.quickView', ':id') }}`;
        console.log(id);
        url = url.replace(':id', id);
        console.log(url);

        try {
            let response = await axios.get(url);
            let site = response.data.site;

            $('#site-name').text(site.name);
            site.owner ? $('#site-owner').text(site.owner.name) : $('#site-owner').text('N/A');
            $('#site-location').text(site.location);
            $('#site-country').text(site.country);
            $('#site-timezone').text(site.timezone);
            $('#site-status').text(site.is_active == 1 ? 'Active' : 'Inactive');
            $('#site-latitude').text(site.lat);
            $('#site-longitude').text(site.long);
            $('#site-guards').text(site.guards.length);

            if (site.media.length > 0) {
                //parse the url
                let url = site.media[0].original_url;
                console.log(url);
                let newUrl = url.replace('http://localhost/storage/', '');
                console.log(newUrl);
                let imageUrl = "{{ asset('storage') }}/" + newUrl;
                $('#site-logo').attr('src', imageUrl);
            } else {
                $('#site-logo').attr('src', 'https://ui-avatars.com/api/?name=' + site.name +
                    '&color=f76b0e&background=ffffff');
            }
            // Initialize the map
            let map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: parseFloat(site.lat),
                    lng: parseFloat(site.long)
                },
                zoom: 14
            });

            let marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(site.lat),
                    lng: parseFloat(site.long)
                },
                map: map,
                draggable: false
            });
            $('#viewSiteModal').modal('show');

        } catch (error) {
            console.log(error);
        }


    }

    function updateSite(id) {
        let url = `{{ route('admin.quickView', ':id') }}`;
        console.log(id);
        url = url.replace(':id', id);

        axios.get(url)
            .then(function(response) {
                let site = response.data.site;
                $('#update-name').val(site.name);
                $('#update-location').val(site.location);
                $('#update-country').val(site.country).trigger('change');
                $('#update-timezone').val(site.timezone).trigger('change');
                $('#update-lat').val(site.lat);
                $('#update-long').val(site.long);


                // Show existing logo if media exists
                if (site.media.length > 0) {
                    let logoUrl = site.media[0].original_url;
                    let newLogoUrl = logoUrl.replace('http://localhost/storage/', '');
                    let existingLogoUrl = "{{ asset('storage') }}/" + newLogoUrl;
                    $('#current-logo').attr('src', existingLogoUrl).show();
                } else {
                    $('#current-logo').attr('src', '').hide();
                }
                $('#updateSiteModal').modal('show');

                // Call initMap here after the modal is displayed
                initMap(site);
            })
            .catch(function(error) {
                console.log(error);
            });

        // Update the site
        $('#updateSiteForm').submit(function(event) {
            event.preventDefault();
            let url = `{{ route('admin.updateSite', ':id') }}`;
            console.log(id);

            url = url.replace(':id', id);
            console.log(url);
            let formData = new FormData();
            formData.append('name', $('#update-name').val());
            formData.append('location', $('#update-location').val());
            formData.append('country', $('#update-country').val());
            formData.append('timezone', $('#update-timezone').val());
            formData.append('lat', $('#update-lat').val());
            formData.append('long', $('#update-long').val());
            formData.append('logo', $('#update-logo')[0].files[0]);

            axios.post(url, formData)
                .then(function(response) {
                    console.log(response);
                    $('#updateSiteModal').modal('hide');
                    window.location.reload();
                })
                .catch(function(error) {
                    console.log(error);
                });
        });


    }

    async function initMap(site) {
        // Parse the values from the input fields
        var inputLat = parseFloat($('#update-lat').val());
        var inputLng = parseFloat($('#update-long').val());

        // Use the input values if they are valid, otherwise use the site values
        var initialLat = !isNaN(inputLat) ? inputLat : (site && !isNaN(parseFloat(site.lat)) ? parseFloat(site
                .lat) :
            0);
        var initialLng = !isNaN(inputLng) ? inputLng : (site && !isNaN(parseFloat(site.long)) ? parseFloat(site
                .long) :
            0);

        // Check if the coordinates are valid numbers
        if (isNaN(initialLat) || isNaN(initialLng)) {
            initialLat = 0;
            initialLng = 0;
        }

        map = new google.maps.Map(document.getElementById('update-address-map'), {
            center: {
                lat: initialLat,
                lng: initialLng
            },
            zoom: 15
        });

        marker = new google.maps.Marker({
            position: {
                lat: initialLat,
                lng: initialLng
            },
            map: map,
            draggable: true
        });

        // Update the latitude and longitude inputs when the marker is dragged
        marker.addListener('dragend', function(event) {
            $('#update-lat').val(event.latLng.lat());
            $('#update-long').val(event.latLng.lng());
        });

        // Update the map center and marker position
        map.setCenter({
            lat: initialLat || 0,
            lng: initialLng || 0
        });

        marker.setPosition({
            lat: initialLat || 0,
            lng: initialLng || 0
        });
    }

    function updateMap() {
        var lat = parseFloat($('#update-lat').val());
        var lng = parseFloat($('#update-long').val());

        // Update the map center and marker position
        map.setCenter({
            lat: lat,
            lng: lng
        });
        marker.setPosition({
            lat: lat,
            lng: lng
        });
    }

    function suspendSite(id) {
        let url = `{{ route('admin.changeSiteStatus', ':id') }}`;
        console.log(id);
        url = url.replace(':id', id);
        console.log(url);

        axios.patch(url)
            .then(function(response) {
                console.log(response);
                //call success function
                let successMessage = 'Site status updated successfully';
                displaySuccess(successMessage);
                //refresh page
                setTimeout(function() {
                    location.reload();
                }, 2000);


            })
            .catch(function(error) {
                console.log(error);
            });
    }

    // Initialize select2 with search
    $(document).ready(function() {
        let countries = @json($countries);
        let timezones = @json($timezones);

        $('#country').select2({
            data: countries,
            allowClear: true,
            placeholder: 'Select Country',
            dropdownParent: $('#addSiteModal'),
            dropdownAutoWidth: true,
            width: '100%',
            searching: true
        });
        $('#update-country').select2({
            data: countries,
            allowClear: true,
            placeholder: 'Select Country',
            dropdownParent: $('#updateSiteModal'),
            dropdownAutoWidth: true,
            width: '100%',
            searching: true
        });

        $('#timezone').select2({
            data: timezones,
            allowClear: true,
            placeholder: 'Select Timezone',
            dropdownParent: $('#addSiteModal'),
            dropdownAutoWidth: true,
            width: '100%',
            searching: true
        });
        $('#update-timezone').select2({
            data: timezones,
            allowClear: true,
            placeholder: 'Select Timezone',
            dropdownParent: $('#updateSiteModal'),
            dropdownAutoWidth: true,
            width: '100%',
            searching: true
        });

        $('#country, #update-country').on('change', function() {
            $(this).val();
        });

        $('#timezone, #update-timezone').on('change', function() {
            $(this).val();
        });
    });
</script>
