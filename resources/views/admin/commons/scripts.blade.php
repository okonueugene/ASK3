  <!-- JavaScript -->
  <script src="{{ asset('assets/js/bundle.js') }}"></script>
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/charts/gd-invest.js') }}"></script>
  <script
      src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap"
      async defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.0/axios.min.js"></script>
  {{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script> --}}
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

  </body>

  </html>
