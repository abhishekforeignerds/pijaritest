<footer class="footer">
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-md-12">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> {{ env('APP_NAME') }} || All Right Reserved.
            </div>

        </div>
    </div>
</footer>
<!-- bundle -->
<script src="{{ asset('user_dashboard/js/vendor.min.js') }}"></script>

<script src="{{ asset('user_dashboard/js/jquery.knob.min.js') }}"></script>
<!-- Apex js-->
<script src="{{ asset('user_dashboard/js/apexcharts.min.js') }}"></script>

<script src="{{ asset('user_dashboard/js/daterangepicker.js') }}"></script>

<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Dashboard init-->
<script src="{{ asset('user_dashboard/js/pages/dashboard-sales.init.js') }}"></script>

<script src="{{ asset('user_dashboard/js/app.min.js') }}"></script>

@foreach (['error', 'warning', 'success', 'info'] as $msg)
        @if (Session::has($msg))
            <script>
                $(function() {
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        icon: "{{ $msg }}",
                        title: "{{ Session::get($msg) }}",
                        showCloseButton: true,
                    });
                });
            </script>
        @endif
    @endforeach
<script type="text/javascript">
    $('#reservation').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#reservation').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + '-' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    function copy_text(text) {
        CopyToClipBoard(text);
    }


    function CopyToClipBoard(textToCopy) {

        var successMessage = 'Success! The text was copied to your clipboard';
        var errorMessage = 'Oops! Copy to clipboard failed. ';

        // navigator clipboard api needs a secure context (https)
        if (navigator.clipboard && window.isSecureContext) {

            // navigator clipboard api method'
            navigator.clipboard.writeText(textToCopy).then(
                function() {
                    /* clipboard successfully set */
                    console.log(successMessage);
                    alert('Copy to clipboard');

                },
                function() {
                    /* clipboard write failed */
                    console.warn(errorMessage);

                }
            )
        } else
        if (document.queryCommandSupported && document.queryCommandSupported("copy")) {

            // text area method
            var textarea = document.createElement("textarea");
            textarea.value = textarea.textContent = textToCopy;
            textarea.style.opacity = "0";

            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();

            var selection = document.getSelection();
            var range = document.createRange();

            range.selectNode(textarea);
            selection.removeAllRanges();
            selection.addRange(range);

            try {
                var successful = document.execCommand('copy'); // Security exception may be thrown by some browsers.
                var msg = successful ? console.log(successMessage) : console.warn(errorMessage);
            } catch (ex) {
                console.warn(errorMessage, ex);
            } finally {
                selection.removeAllRanges();
                document.body.removeChild(textarea);
            }
        }
    }
</script>
