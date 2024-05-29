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
                                    <p>You have total {{ count($records) }} attendance records.</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <div class="btn-group" aria-label="Basic example">
                                        <button type="button" class="btn  btn-sm btn-outline-primary"
                                            onclick="exportPDF()">PDF</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="exportExcel('xlsx')">XLS</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="exportExcel('csv')">CSV</button>
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
                                                <select id="selectedSite" class="form-control">
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
                                            <select id="selectedGuard" class="form-control" name="city_id">
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
                                                    id="start" type="text" class="form-control start-date" />
                                                <div class="input-group-addon">TO</div> <input id="end" type="text"
                                                    class="form-control end-date" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <button class="btn btn-sm btn-secondary" onclick="filterRecords()">
                                        Filter Records</button>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="resetFilters()">
                                        Reset
                                        Filters</button>
                                </div><!-- .toggle-wrap -->
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div id="loading" class="spinner-border text-info" role="status"
                                        style="position:absolute;left:50%;top:25%;z-index:1000;display:none">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    @if (count($records) > 0)
                                        <table id="attendance-report" class="datatable-init nk-tb-list nk-tb-ulist"
                                            data-auto-responsive="false">
                                            <thead>
                                                <tr class="nk-tb-item nk-tb-head">
                                                    <th class="nk-tb-col nk-tb-col-check">
                                                        <div
                                                            class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="uid">
                                                            <label class="custom-control-label" for="uid"></label>
                                                        </div>
                                                    </th>
                                                    <th class="nk-tb-col"><span class="sub-text">Guard</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Site</span></th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Date</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Time In</span>
                                                    </th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Time Out</span>
                                                    </th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Total
                                                            Hours</span>
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($records as $record)
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
                                                            @if ($record->time_out)
                                                                <span>{{ Carbon\Carbon::parse($record->time_in)->floatDiffInHours($record->time_out) }}</span>
                                                            @else
                                                                <span class="text-danger">Not Available</span>
                                                            @endif
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
                                </div><!-- .card-inner -->
                            </div>

                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    //listen for the click event on the site filter
    $(document).ready(function() {
        $('#selectedSite').on('change', function() {
            //get the selected site
            let siteId = $(this).val();

            //get the url
            let url = `{{ route('admin.getSiteGuards', ':siteId') }}`;

            //replace the :siteId with the actual siteId
            url = url.replace(':siteId', siteId);

            // Make axios call
            axios.post(url)
                .then((response) => {

                    let guards = response.data.guards;

                    // Remove existing options
                    $('#selectedGuard').find('option').remove();

                    // Add new options
                    $('#selectedGuard').append('<option value="" selected>Choose Guard</option>');
                    guards.forEach(guard => {
                        $('#selectedGuard').append(
                            `<option value="${guard.id}">${guard.name}</option>`);
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        });
    });

    const filterRecords = () => {

        //get the selected site
        let siteId = '';
        let selectedSite = $('#selectedSite').val();
        if (selectedSite != 'Choose Site') {
            siteId = selectedSite;
        }

        //get the selected guard
        let selectedGuard = $('#selectedGuard').val();
        if (selectedGuard != 'Choose Guard') {
            guardId = selectedGuard;
        }

        //get the selected date range
        let startDate = $('#start').val();
        let endDate = $('#end').val();

        //get the url
        let url =
            `{{ route('admin.filterAttendanceRecords') }}?site_id=${siteId}&guard_id=${guardId}&start_date=${startDate}&end_date=${endDate}`;
        console.log(url);
        //show the spinner
        let spinner = document.getElementById('loading');
        spinner.style.display = 'block';
        // Make axios call
        axios.post(url)
            .then((response) => {
                if (response.status === 200) {
                    displaySuccess('Records filtered successfully.');
                } else {
                    displayError(response.data.message);
                }
                let filteredRecords = response.data.records;
                console.log(filteredRecords);
                // Remove existing DataTable data
                let table = $('#attendance-report').DataTable();

                table.clear().draw();

                // Add new DataTable data
                filteredRecords.forEach(record => {
                    table.row.add([
                        `<div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" wire:click="selectRecord(${record.id})" id="uid${record.id}">
                            <label class="custom-control-label" for="uid${record.id}"></label>
                        </div>`,
                        `<div class="user-card">
                            <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                <span>${record.owner.name[0]}</span>
                            </div>
                            <div class="user-info">
                                <span class="tb-lead">${record.owner.name} <span class="dot dot-success d-md-none ml-1"></span></span>
                                <span>${record.owner.phone}</span>
                            </div>
                        </div>`,
                        `<span>${record.site.name}</span>`,
                        `<span>${record.day}</span>`,
                        `<span>${record.time_in}</span>`,
                        `<span>${record.time_out ? record.time_out : 'Not Available'}</span>`,
                        `<span>${record.time_out ? diffInHours(record.time_in, record.time_out) : 'Not Available'}</span>`
                    ]).draw(false);
                });
                //remove the spinner
                spinner.style.display = 'none';

            })
            .catch((error) => {
                console.log(error);

                // Display an error message
                displayError(error.response.data.message);
            });

    }

    const resetFilters = () => {
        // Reset the site filter
        $('#selectedSite').val('Choose Site');

        // Reset the guard filter
        $('#selectedGuard').val('Choose Guard');

        // Reset the date range filter
        $('#start').val('');
        $('#end').val('');

        // Reload the page
        location.reload();
    }

    function exportExcel(ext) {
        //get the selected site
        let siteId = '';
        let selectedSite = $('#selectedSite').val();
        if (selectedSite != 'Choose Site') {
            siteId = selectedSite;
        }

        //get the selected guard
        let selectedGuard = $('#selectedGuard').val();
        if (selectedGuard != 'Choose Guard') {
            guardId = selectedGuard;
        }

        //get the selected date range
        let startDate = $('#start').val();
        let endDate = $('#end').val();


        let url =
            `{{ route('admin.exportAttendanceRecords') }}?site_id=${siteId}&guard_id=${guardId}&start_date=${startDate}&end_date=${endDate}&ext=${ext}`;
        //show the spinner
        let spinner = document.getElementById('loading');
        spinner.style.display = 'block';
        //make axios call
        axios.get(url)
            .then((response) => {

                // Check the response status and display success or error message
                if (response.status === 200) {
                    displaySuccess('Records exported successfully.');
                } else {

                    displayError(response.data.message);
                }
            })
            .catch((error) => {
                console.log(error);

                // Display an error message
                displayError(error.response.data.message);
            });


        // Create a hidden iframe to handle the download
        let iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = url;
        document.body.appendChild(iframe);

        //remove the spinner
        spinner.style.display = 'none';
    }
</script>
<script>
    function exportPDF() {
        let spinner = document.getElementById('loading');
        spinner.style.display = 'block';

        //get the selected site
        let siteId = '';

        let selectedSite = $('#selectedSite').val();
        if (selectedSite != 'Choose Site') {
            siteId = selectedSite;
        }

        //get the selected guard
        let selectedGuard = $('#selectedGuard').val();
        if (selectedGuard != 'Choose Guard') {
            guardId = selectedGuard;
        }

        //get the selected date range
        let startDate = $('#start').val();
        let endDate = $('#end').val();
        console.log(siteId, guardId, startDate, endDate);

        //get the url
        let url =
            `{{ route('admin.exportAttendancePDF') }}?site_id=${siteId}&guard_id=${guardId}&start_date=${startDate}&end_date=${endDate}&ext=pdf`;

        // Make axios call

        axios.get(url)
            .then((response) => {

                // Check the response status and display success or error message
                if (response.status === 200) {
                    displaySuccess('PDF generated successfully.');
                } else {

                    displayError(response.data.message);

                    // Hide the spinner
                    spinner.style.display = 'none';
                }

                // Create a hidden iframe to handle the download
                let iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = url;
                document.body.appendChild(iframe);

                // Hide the spinner
                spinner.style.display = 'none';

            })
            .catch((error) => {
                console.log(error);

                // Display an error message
                displayError(error.response.data.message);

                // Hide the spinner
                spinner.style.display = 'none';
            });


    }
</script>
