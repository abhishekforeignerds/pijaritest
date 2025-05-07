<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    @yield('meta')
    <!-- Favicons -->
    @if (!empty(appSetupValue('favicon')))
    <link rel="icon" href="{{ asset('backend/images/app_setup/' . appSetupValue('favicon')) }}"
        onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/favicon.png') }}'" />
    @endif

    <meta name="description" content="@yield('meta_description', 'Default site description')">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '497829213423493');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=497829213423493&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NG7KSN3F');
    </script>
    <!-- End Google Tag Manager -->
    @livewireStyles
</head>

<body>
    <style>
        /* Loader styles */

        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.5);
            /* Semi-transparent overlay */
            backdrop-filter: blur(10px);
            /* Apply the blur effect */
            z-index: 10;
        }

        #loader img {
            width: 50px;
            /* Customize size */
        }
    </style>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NG7KSN3F" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="page-wrapper">

        @include('frontend.layouts.header')

        @isset($slot)
        {{ $slot }}
        @else
        <div id="loader" style="display:none;">
            <img src="https://media.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="Loading...">
        </div>

        @yield('content')
        @endisset
        @livewireScripts
        @include('frontend.layouts.footer')

        <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/wow.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/swiper.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/appear.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
        @stack('scripts')
        <script>
            function add_to_cart(product_id, package_id) {
console.log('called')
                const checkedBoxes = document.querySelectorAll('.inclusion-checkbox_' + package_id + ':checked');
                const checkedIds = Array.from(checkedBoxes).map(box => box.value);

                $.ajax({
                    type: "POST",
                    async: true,
                    dataType: 'json',
                    url: "{{ route('cart.add') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: product_id,
                        package_id: package_id,
                        inclusion: checkedIds
                    },
                    success: function(response) {
                        $('#package_list').html(response.package_list);
                        $('#order_summary').html(response.order_summary);
                        $('#cart_count').text(response.cart_total_item);
                        // location.reload();
                        document.querySelectorAll(".read-more-btn").forEach(button => {
                            button.addEventListener("click", function () {
                                const description = this.previousElementSibling;

                                if (description.classList.contains("full")) {
                                    description.classList.remove("full");
                                    this.textContent = "Read More";
                                } else {
                                    description.classList.add("full");
                                    this.textContent = "Read Less";
                                }
                            });
                        });
                        updateCartTable(response.items);
                        updateTotals(response.totals);
                    }
                });

            }
            /**
             * Completely rebuilds the <tbody> of both English & Hindi tables
             * @param {Array} items
             */
             function updateCartTable(items) {
                const engBody = document.getElementById('cart-tbody-english');
                const hinBody = document.getElementById('cart-tbody-hindi');

                // only clear if present
                if (engBody) engBody.innerHTML = '';
                if (hinBody) hinBody.innerHTML = '';

                items.forEach(cart => {
                    // English rows if table exists
                    if (engBody) {
                        // package row
                        const trPkgE = document.createElement('tr');
                        trPkgE.innerHTML = `<td colspan="2">Package : ${cart.package_name}</td>`;
                        engBody.appendChild(trPkgE);

                        // inclusions
                        if (cart.inclusions.length) {
                            cart.inclusions.forEach(i => {
                                const trE = document.createElement('tr');
                                trE.innerHTML = `<td>${i.name}: <span>Included</span></td><td>Rs ${i.price}</td>`;
                                engBody.appendChild(trE);
                            });
                        } else {
                            const noneE = document.createElement('tr');
                            noneE.innerHTML = `<td colspan="2">No inclusions available.</td>`;
                            engBody.appendChild(noneE);
                        }
                    }

                    // Hindi rows if table exists
                    if (hinBody) {
                        // package row
                        const trPkgH = document.createElement('tr');
                        trPkgH.innerHTML = `<td colspan="2">पैकेज : ${cart.package_name_hindi}</td>`;
                        hinBody.appendChild(trPkgH);

                        // inclusions
                        if (cart.inclusions.length) {
                            cart.inclusions.forEach(i => {
                                const trH = document.createElement('tr');
                                trH.innerHTML = `<td>${i.name_hindi}: <span>समाविष्ट</span></td><td>Rs ${i.price}</td>`;
                                hinBody.appendChild(trH);
                            });
                        } else {
                            const noneH = document.createElement('tr');
                            noneH.innerHTML = `<td colspan="2">कोई समावेश उपलब्ध नहीं है।</td>`;
                            hinBody.appendChild(noneH);
                        }
                    }
                });
            }

            function updateTotals(t) {
                const checkoutBtn = document.getElementById('checkout-btn');
                if (t.subtotal > 0 && checkoutBtn) {
                    checkoutBtn.classList.remove('disabled');
                    checkoutBtn.style.pointerEvents = 'auto';
                    checkoutBtn.style.opacity = '1';
                } else if (checkoutBtn) {
                    checkoutBtn.classList.add('disabled');
                    checkoutBtn.style.pointerEvents = 'none';
                    checkoutBtn.style.opacity = '0.5';
                }
                
                document.getElementById('total').textContent         = t.subtotal;
                document.getElementById('total_amount').textContent  = t.subtotal;
                document.getElementById('advance_amount').textContent= t.advance;
                var second_advance = document.getElementById('second_advance_amount');
                if(second_advance){
                    second_advance.textContent = t.advance;
                }
                document.getElementById('remaining_amount').textContent = t.remaining;
                document.getElementById('grand_total').textContent   = t.grand_total;
            }


            function set_city() {
                var city = $('#city').val();
                $.ajax({
                    url: "{{ route('set_city') }}", // Laravel route
                    type: "GET",
                    data: {
                        city: city,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        //window.location.href = window.location.href;
                    },
                    error: function(xhr) {
                        console.log("Error:", xhr);
                    }
                });
            }

            function set_language() {
                var language = $('#language').val();
                $.ajax({
                    url: "{{ route('set_language') }}",
                    type: "GET",
                    data: {
                        pooja_language: language,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        //window.location.href = window.location.href;
                    },
                    error: function(xhr) {
                        console.log("Error:", xhr);
                    }
                });
            }

            $(document).ready(function() {
                $('.js-example-basic-single').select2();

                $(document).ajaxStart(function() {
                    // $('#loader').show();
                });

                // Hide loader whenever an AJAX request finishes (success or error)
                $(document).ajaxStop(function() {
                    // $('#loader').hide();
                });
            });

            function set_pooja_language() {
                var pooja_language = $('#cbx').is(':checked') ? 'English' : 'hindi'; // Check if checkbox is checked

                $.ajax({
                    url: "{{ route('set_pooja_language') }}",
                    type: "GET",
                    data: {
                        pooja_language: pooja_language,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        location.reload(); // Reload the page after setting the language
                    },
                    error: function(xhr) {
                        console.log("Error:", xhr);
                    }
                });
            }

            // Bind the function to the checkbox change event
            $('#cbx').change(function() {
                set_pooja_language();
            });
        </script>
        <!--Start of Tawk.to Script-->
        {{-- <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/67a4613d3a842732607a6842/1ijd1nmab';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script> --}}
        <!--End of Tawk.to Script-->

        <script type="text/javascript" src="https://d3mkw6s8thqya7.cloudfront.net/integration-plugin.js"
            id="aisensy-wa-widget" widget-id="5MVm77">
        </script>

    </div>
</body>

</html>