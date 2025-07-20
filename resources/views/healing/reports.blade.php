@extends('healing.layout.layout')

@section('content')

<style>
    .home-main-page {
    min-height: 80vh;
}
#loading{
    text-align: center;
}
.submitButton{
    width: 100%;
}

.buttonparent {
    padding: 15px 15px;
}

</style>
  <div class="main-container">
    <div id="app">
  <div class="view view-main view-init ios-edges">
    <div class="page page-home page-with-subnavbar home-main-page">
      <div class="tabs">
        <div id="tab-home" class="tab tab-active tab-home">

          <!-- Top Bar -->
          <div class="navbar navbar-home">
            <div class="navbar-inner header-top-bar">
              <div class="back-link">
                <a class="link back" href="/">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z" />
                  </svg>
                </a>
              </div>
              <div class="header-title">Your Reports</div>
              <div></div>
            </div>
          </div>

          <!-- Heading -->
          <div class="yourrequestsBox">
            <p>Healings You Have Done</p>
          </div>

          <!-- Healing Reports -->
        <div id="printableReports">  <div class="myHealingRequests" id="healingReports"></div></div>

          <!-- Loading Indicator -->
          <div id="loading" class="text-center text-muted mt-2" style="display: none;">
            Loading Reports...
          </div>

          <!-- No Reports -->
          <div id="noReports" class="text-center text-muted mt-2" style="display: none;">
            No healing reports found.
          </div>

          <div class="text-end px-3 buttonparent">
    <button class="btn btn-primary btn-sm submitButton" onclick="printReports()">🖨️ Print</button>
</div>


        </div>

        @include('healing.layout.bottombar')
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    fetchHealingReports();

    function fetchHealingReports() {
        $("#loading").show();
        $("#noReports").hide();
        $("#healingReports").empty();

        $.get('/healer/reports/fetch', function (response) {
            $("#loading").hide();

            if (!response || Object.keys(response).length === 0) {
                $("#noReports").show();
                return;
            }

            $.each(response, function (date, items) {
                let formattedDate = new Date(date).toLocaleDateString('en-GB', {
                    year: 'numeric', month: 'short', day: 'numeric'
                });

                let html = `<div class="listBox reportbox">
                                <div class="right-box">
                                    <p class="fw-bold mb-1">${formattedDate}</p>
                                    <div><ul>`;

                items.forEach(item => {
                    let time = new Date('1970-01-01T' + item.time).toLocaleTimeString([], {
                        hour: '2-digit', minute: '2-digit'
                    });

                    html += `<li>${item.user?.user_code ?? 'N/A'} - ${time} - For ${item.healing_requirement}</li>`;
                });

                html += `       </ul></div>
                                </div>
                            </div>`;

                $("#healingReports").append(html);
            });
        });
    }
});


function printReports() {
    const printContents = document.getElementById('printableReports').innerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = `
        <html>
        <head>
            <title>Healing Reports</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                ul { padding-left: 20px; }
                li { margin-bottom: 5px; }
                .reportbox { border: 1px solid #ddd; padding: 10px; margin-bottom: 15px; }
                .fw-bold { font-weight: bold; }
            </style>
        </head>
        <body>
            <h2>Healing Reports</h2>
            ${printContents}
        </body>
        </html>
    `;

    window.print();
    location.reload(); // restore original page after printing
}

</script>
@endsection
