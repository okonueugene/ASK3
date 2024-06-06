@extends('admin.layouts.layout')

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
</head>
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
                                                <select class="custom-select form-select" id="selectedSite" name="site_id">
                                                    <option value="" selected>Choose Site</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- @if (auth()->user()->user_type == 'client' || !is_null($selectedSite)) --}}
                                    <div class="form-group mr-2">
                                        <label class="form-label">Filter By Guard</label>
                                        <div class="form-control-wrap">
                                            <select class="custom-select form-select" id="selectedGuard" name="guard_id">
                                                <option value="" selected>Choose Guard</option>
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
                                        <table id="patrol-report" class="table table-striped-columns table-bordered"
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
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Site</span>
                                                    </th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Tag</span></th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Date</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Time</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span>
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($records as $record)
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
                                                            <span>{{ $record->tag->name }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $record->date }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span>{{ $record->time }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span>{{ $record->status }}</span>
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
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable once
        let dataTable = $('#patrol-report').DataTable({
            "responsive": true,
        });

        // Listen for changes on the site filter
        $('#selectedSite').on('change', function() {
            let siteId = $(this).val();
            let url = `{{ route('admin.getSiteGuards', ':siteId') }}`.replace(':siteId', siteId);

            axios.post(url)
                .then((response) => {
                    let guards = response.data.guards;
                    $('#selectedGuard').find('option').remove();
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

        window.filterRecords = function() {
            let siteId = $('#selectedSite').val();
            let guardId = $('#selectedGuard').val();
            let startDate = $('#start').val();
            let endDate = $('#end').val();
            let url =
                `{{ route('admin.filterRecords') }}?site_id=${siteId}&guard_id=${guardId}&start_date=${startDate}&end_date=${endDate}`;
            let spinner = document.getElementById('loading');
            spinner.style.display = 'block';

            axios.post(url)
                .then((response) => {
                    let filteredRecords = response.data.records;
                    dataTable.clear().draw();
                    if (filteredRecords.length === 0) {
                        displayError('No records found.');
                    } else {
                        displaySuccess('Records filtered successfully.');
                        filteredRecords.forEach(record => {
                            dataTable.row.add([
                                `<div class="custom-control custom-control-sm custom-checkbox notext">
                    <input type="checkbox" class="custom-control-input" id="uid">
                    <label class="custom-control-label" for="uid"></label>
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
                                `<span>${record.tag.name}</span>`,
                                `<span>${record.date}</span>`,
                                `<span>${record.time}</span>`,
                                `<span>${record.status}</span>`
                            ]).draw();
                        });
                    }
                    spinner.style.display = 'none';
                })
                .catch((error) => {
                    console.log(error);
                    displayError(error.response.data.message);
                    spinner.style.display = 'none';
                });
        }

        window.resetFilters = function() {
            $('#selectedSite').val('Choose Site');
            $('#selectedGuard').val('Choose Guard');
            $('#start').val('');
            $('#end').val('');
            location.reload();
        }

        window.exportExcel = function(ext) {
            let siteId = $('#selectedSite').val();
            let guardId = $('#selectedGuard').val();
            let startDate = $('#start').val();
            let endDate = $('#end').val();
            let url =
                `{{ route('admin.exportRecords') }}?site_id=${siteId}&guard_id=${guardId}&start_date=${startDate}&end_date=${endDate}&ext=${ext}`;
            let spinner = document.getElementById('loading');
            spinner.style.display = 'block';

            //if any of the filters is not null, export the filtered records
            if (siteId !== 'Choose Site' || guardId !== 'Choose Guard' || startDate !== '' || endDate !==
                '') {
                axios.get(url)
                    .then((response) => {
                        if (response.status === 200) {
                            displaySuccess('Records exported successfully.');
                        } else {
                            displayError(response.data.message);
                        }
                        spinner.style.display = 'none';
                    })
                    .catch((error) => {
                        console.log(error);
                        displayError(error.response.data.message);
                        spinner.style.display = 'none';
                    });

                let iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = url;
                document.body.appendChild(iframe);
                spinner.style.display = 'none';
            } else {
                displayError('Please filter records before exporting.');
                spinner.style.display = 'none';
            }


        }

        window.exportPDF = function() {
            let siteId = $('#selectedSite').val();
            let guardId = $('#selectedGuard').val();
            let startDate = $('#start').val();
            let endDate = $('#end').val();
            let url =
                `{{ route('admin.exportPDF') }}?site_id=${siteId}&guard_id=${guardId}&start_date=${startDate}&end_date=${endDate}`;
            let spinner = document.getElementById('loading');
            spinner.style.display = 'block';
            console.log(startDate, endDate);

            //if any of the filters is not null, export the filtered records
            if (siteId !== 'Choose Site') {
                axios.get(url)
                    .then((response) => {
                        if (response.status === 200) {
                            displaySuccess('PDF generated successfully.');
                        } else {
                            displayError(response.data.message);
                        }
                        spinner.style.display = 'none';
                    })
                    .catch((error) => {
                        console.log(error);
                        displayError(error.response.data.message);
                        spinner.style.display = 'none';
                    });

                let iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = url;
                document.body.appendChild(iframe);
                spinner.style.display = 'none';
            } else {
                displayError('Please filter records before exporting.');
                spinner.style.display = 'none';
            }

        }

        //initialize select2
        let sites = @json($sites);
        let guards = @json($guards);

        sites.forEach(site => {
            $('#selectedSite').append(
                `<option value="${site.id}">${site.name}</option>`);
        });

        $('#selectedSite').select2({
            placeholder: 'Select Site',
            allowClear: true,
            width: '100%',
            dropdownAutoWidth: true,
            dropdownParent: $('#selectedSite').parent(),
            searching: true,
        });

        guards.forEach(guard => {
            $('#selectedGuard').append(
                `<option value="${guard.id}">${guard.name}</option>`);
        });

        $('#selectedGuard').select2({
            placeholder: 'Choose Guard',
            allowClear: true,
            width: '100%',
            dropdownAutoWidth: true,
            dropdownParent: $('#selectedGuard').parent(),
            searching: true,
        });

    });
</script>
