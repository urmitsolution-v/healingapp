@extends('healing.layout.layout')
@section('content')
    <style>
        .page.page-home {
    padding-bottom: 90px !important;
}
#alert-msg .alert{
        color: #ff6f61;
    background-color: #ff6f6114;
    padding: 10px;
    border-radius: 9px;
}

.paddingttt{
        padding: 20px 16px !important; 
}
/* Success toast full green on hover */
.toast-success {
    background-color: #28a745 !important; /* Bootstrap green */
    color: white !important;
}

/* Error toast full red on hover */
.toast-error {
    background-color: #dc3545 !important; /* Bootstrap red */
    color: white !important;
}
#toast-container>div {
    opacity: 1 !important;
}
</style>
    <div class="main-container">
         <div id="app">
            <div class="view view-main view-init ios-edges">
               <div class="page page-home page-with-subnavbar home-main-page">
                  <div class="tabs">
                     <div id="tab-home" class="tab tab-active tab-home">
                        <!-- home -->
                       <div class="navbar navbar-home">
                        <div class="navbar-inner header-top-bar">
                           <div class="back-link">
                            <a class="link back" href="/healing-requests">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path></svg>
                        </a></div>
                           <div class="header-title">New Healing Request</div>
                           <div class="">
                           </div>
                        </div>
                      </div>

                        <div class="yourrequestsBox">
                            <p>Make A Request for Healing</p>
                        </div>

                 <div class="myHealingRequests">

    <div id="alert-msg"></div> {{-- Success/Validation Message --}}

    <input type="text" placeholder="Healing Requirement" id="healing_requirement" class="form-control paddingttt" />

    <div class="form-group mt-3">
        <label for="date">Preferred Date & Time</label>
        <input type="date" id="date" class="form-control" />
        <input type="time" id="time" class="form-control mt-2" />
    </div>

 <button class="submitButton btn btn-primary mt-3">
    <span class="btn-text">Submit</span>
    <i class="fa fa-spinner fa-spin d-none ms-2"></i>
</button>

                        <br>
                        <br>
                        <br>
                        <br>
                        </div>

                  </div>
                        @include('healing.layout.bottombar')
               </div>
            </div>
         </div>
      </div>
@section('scripts')
<script>
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000"
};
</script>

<script>
document.getElementById('date').valueAsDate = new Date();

setInterval(() => {
    const now = new Date();
    now.setHours(now.getHours() + 1); // Add 1 hour
    document.getElementById('time').value = now.toTimeString().slice(0, 5); // hh:mm
}, 1000);


// Handle submit
document.querySelector('.submitButton').addEventListener('click', () => {
    const healing_requirement = document.getElementById('healing_requirement').value.trim();
    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;
    const button = document.querySelector('.submitButton');
    const btnText = button.querySelector('.btn-text');
    const spinner = button.querySelector('.fa-spinner');

    // Frontend validation
    if (!healing_requirement || !date || !time) {
        toastr.error("All fields are required.");
        return;
    }

    // Disable button and show spinner
    button.disabled = true;
    spinner.classList.remove('d-none');
    btnText.textContent = 'Submitting...';

    fetch('/submit-healing-request', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ healing_requirement, date, time })
    })
    .then(res => res.json())
    .then(data => {
        button.disabled = false;
        spinner.classList.add('d-none');
        btnText.textContent = 'Submit';

        if (data.success) {
            toastr.success(data.message);
            document.getElementById('healing_requirement').value = '';
        } else {
            toastr.error(data.message || 'Something went wrong!');
        }
    })
    .catch(err => {
        button.disabled = false;
        spinner.classList.add('d-none');
        btnText.textContent = 'Submit';
        toastr.error("Server error! Please try again.");
    });
});
</script>
@endsection
@endsection