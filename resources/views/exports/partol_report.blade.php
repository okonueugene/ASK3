
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Report</title>
    <style>
      body {
        font-family: "lato", sans-serif;
      }

      .container {
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
        padding-left: 10px;
        padding-right: 10px;
      }

      .head {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
      }

      .logo {
        width: 100px;
      }

      .head h1 {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
        margin-top: 10px;
      }

      .head small {
        font-size: 14px;
        font-weight: 400;
      }

      .container {
        margin-top: 20px;
      }

      .responsive-table {
        li {
          border-radius: 3px;
          padding: 25px 30px;
          display: flex;
          justify-content: space-between;
          margin-bottom: 5px;
        }

        .table-header {
          background-color: #95a5a6;
          font-size: 14px;
          text-transform: uppercase;
          letter-spacing: 0.03em;
        }

        .table-row {
          box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.1);
        }
        .responsive-table .table-row:nth-child(even) {
          background-color: #f2f2f2 !important; /* or any other color for even rows */
        }

        .responsive-table .table-row:nth-child(odd) {
          background-color: #ffffff !important; /* or any other color for odd rows */
        }

        @media all and (max-width: 767px) {
          .table-header {
            display: none;
          }
          .table-row {
          }
          li {
            display: block;
          }
          .col {
            flex-basis: 100%;
          }
          .col {
            display: flex;
            padding: 10px 0;
            &:before {
              color: #6c7a89;
              padding-right: 10px;
              content: attr(data-label);
              flex-basis: 50%;
              text-align: right;
            }
          }
        }
      }
    </style>
  </head>
  <body>
    <div class="head">
      <img
        src="https://www.opticom.co.ke/wp-content/uploads/2023/03/cropped-Opticom-Logo-18.png"
        alt="logo"
        class="logo"
      />
      <h1>Opticom Kenya Limited</h1>
      <small>Remote Monitoring Solutions</small>
    </div>
    <div class="container">
      <ul class="responsive-table" id="patrol-report">
        <li class="table-header">
          <div class="col col-1">ID</div>
          <div class="col col-2">Owner</div>
          <div class="col col-3">Site</div>
          <div class="col col-4">Tag</div>
          <div class="col col-5">Date</div>
          <div class="col col-6">Time</div>
          <div class="col col-7">Status</div>
        </li>
        @foreach ($patrols as $patrol)
          <li class="table-row">
            <div class="col col-1" data-label="ID">{{ $patrol->id }}</div>
            <div class="col col-2" data-label="Owner">{{ $patrol->owner }}</div>
            <div class="col col-3" data-label="Site">{{ $patrol->site }}</div>
            <div class="col col-4" data-label="Tag">{{ $patrol->tag }}</div>
            <div class="col col-5" data-label="Date">{{ $patrol->date }}</div>
            <div class="col col-6" data-label="Time">{{ $patrol->time }}</div>
            <div class="col col-7" data-label="Status">{{ $patrol->status }}</div>
          </li>
        @endforeach
      </ul>
    </div>
  </body>
</html>