<!DOCTYPE html>
<html>

<head>
    <title>ASKARI</title>
    <style>
        .header {
            text-align: center;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: rgb(246, 246, 246);
            color: white;
            text-align: center;
        }

        .footer .office {
            color: rgb(82, 158, 200);
            margin-top: 3px;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td {
            font-size: 12px;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #ef6a00;
            color: white;
        }

        /**
            * Set the margins of the PDF to 0
            * so the background image will cover the entire page.
            **/
        @page {
            margin: 0cm 0cm;
        }

        /**
            * Define the real margins of the content of your PDF
            * Here you will fix the margins of the header and footer
            * Of your background image.
            **/
        body {
            margin-top: 0.3cm;
            margin-bottom: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
        }

        /**
            * Define the width, height, margins and position of the watermark.
            **/
        #watermark {
            position: fixed;
            bottom: 9%;
            left: -24%;
            /** The width and height may change
                    according to the dimensions of your letterhead
                **/
            width: 147%;
            height: 80%;

            /** Your watermark should be behind every content**/
            z-index: -1000;
        }
    </style>
</head>

<body>
    {{-- <div id="watermark">
        <img style="opacity: 0.3;"
            src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('newlogo.png'))) }}" height="100%"
            width="100%" />
    </div> --}}

    <div class="header">
        <table class="table">
            <tr>
                <td width="33.3%" align="center">
                    <img style="display:block;" height="100px"
                    src="https://askaritechnologies.com/wp-content/uploads/2022/11/ASKARI-LOGO-PNG-01-100x88.png"
                    />
                </td>
                <td width="33.3%" align="center">

                    <div><strong class="font-weight-semibold">{{ $site->name }}</strong></div>
                    <div>{{ $site->location }}</div>
                    <div>{{ $site->timezone }}</div>
                </td>
            </tr>
        </table>

        <hr style="background-color: #ef6a00; height:2px">

        <table class="table">
            <tr>
                <td width="20%" align="Left">
                    <h6 class="text-big text-large font-weight-bold mb-3">
                        <span style="text-transform:uppercase;">Report No #PTR-</span>{{ $timestamp }}
                    </h6>
                </td>
                <td width="60%" align="center"> <strong class="font-weight-bold">
                        <h3>{{ $reportTitle }}</h3>
                    </strong></td>
                <td width="20%" align="right">
                    <div>Date: <strong class="font-weight-semibold">{{ date('m/d/Y') }}</strong></div>
                </td>

            </tr>

        </table>

    </div>
    <br>


    <table id="customers">
        <tr>
            <th>Guard Name</th>
            <th>Site</th>
            <th>Date</th>
            <th>Time-In</th>
            <th>Time-Out</th>
            <th>Hours Worked</th>
        </tr>
        @foreach ($records as $record)
            <tr>
                <td class="nk-tb-col tb-col-md">{{ $record->owner->name }}</td>
                <td class="nk-tb-col tb-col-md">{{ $record->owner->site->name ?? 'No Site' }}</td>
                <td class="nk-tb-col tb-col-md">{{ $record->day }}</td>
                <td class="nk-tb-col tb-col-md">{{ $record->time_in }}</td>
                <td class="nk-tb-col tb-col-md">{{ $record->time_out ?? 'N/A' }}</td>
                <td class="ml-2 badge badge-success">
                    {{ $record->time_out ? \Carbon\Carbon::parse($record->time_out)->diffInHours($record->time_in) : 'N/A' }}
                </td>

            </tr>
        @endforeach
    </table>

    <div class="footer">
        <div class="office">Head office: Optimum Group Partnerships Limited 483 Green Lanes, Palmers Green London N13
            4BS.
        </div>
        <div style="color: black">For any enquires please contact control@optimum-group.co.uk Phone 020 88877244</div>
        <br>
    </div>
</body>

</html>
