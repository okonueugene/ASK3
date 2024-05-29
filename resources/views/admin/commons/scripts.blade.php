<div class="modal fade" id="sosModal" tabindex="-1" aria-labelledby="sosModalExample" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-body p-5 text-center bg-danger text-white">
                <div class="nk-block-head-content">
                    <h5 class="nk-block-title text-white">SOS Alert</h5>
                    <div class="nk-block-des">
                        <p class="text-white">You have an SOS alert from a user. Click anywhere to view the alert.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="{{ asset('assets/js/bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/charts/gd-invest.js') }}"></script>
<script async
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&loading=async&callback=initMap">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.0/axios.min.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
<script src="{{ asset('assets/js/select2/dist/js/select2.min.js') }}"></script>
<script>
    @if (session('success'))
        window.onload = function() {
            iziToast.success({
                title: "Success",
                message: "{{ session('success') }}",
                position: "topRight",
                timeout: 10000,
                transitionIn: "fadeInDown"
            });
        };
    @endif
    @if (session('error'))
        window.onload = function() {
            iziToast.error({
                title: "Error",
                message: "{{ session('error') }}",
                position: "topRight",
                timeout: 10000,
                transitionIn: "fadeInDown"
            });
        };
    @endif
    function displayError(message) {
        iziToast.error({
            title: 'Error',
            message: message,
            position: 'topRight'
        });

    }


    function displaySuccess(message) {
        iziToast.success({
            title: 'Success',
            message: message,
            position: 'topRight'
        });


    }
</script>
<script>
    @if ($errors->any())
        window.onload = function() {
            // Loop through each error message and display it using IziToast
            @foreach ($errors->all() as $error)
                iziToast.error({
                    title: "Error",
                    message: "{{ $error }}",
                    position: "topRight",
                    timeout: 10000,
                    transitionIn: "fadeInDown"
                });
            @endforeach
        };
    @endif
</script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('46a7ec3279ff28a79f9c', {
        cluster: 'mt1'
    });

    var channel = pusher.subscribe('sos-channel');
    channel.bind('sos-event', function(data) {
        $(document).ready(function() {
            $('#sosModal').modal('show');

            //onclick event for the modal
            $('#sosModal').on('click', function() {
                let audio = new Audio('{{ asset('/audio/sos.mp3') }}');
                audio.play();
                //redirect to the sos page
                setTimeout(() => {
                    window.location.href = '{{ route('sos-alerts') }}';
                }, 4000);

                //close the modal
                $('#sosModal').modal('hide');

            });

        });
    });
</script>
</body>

</html>
