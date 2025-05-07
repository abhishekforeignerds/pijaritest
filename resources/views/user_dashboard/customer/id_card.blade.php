@extends('user_dashboard.layouts.app')
@section('content')
    <style type="text/css">
        @media print {
        .noprint {display: none;}
        .side-navbar {display: none;}
        .navbar {display: none;}
        .printMe {display: block;}
        .icard {
            background: #fff;
            width: 500px;
            margin: 0 auto
        }

    }
        .icard {
            background: #fff;
            width: 500px;
        }

        .usr {
            /* padding: 0px 20px; */
        }

        .icard img {
            width: 100%;
        }

        .usr img {
            width: 90px;
            border: solid 1px #ddd;
            margin: 0 0 15px;
            height: 100px;
        }

        .usr h4 {
            font-family: sans-serif;
            font-size: 18px;
            text-align: left;
        }

        .usr ul {
            text-align: left;
            padding-bottom: 10px;
        }

        .usr ul li {
            font-family: sans-serif;
            font-size: 13px;
            list-style: none;
        }

        .usr p {
            font-size: 11px;
            font-family: sans-serif;
            line-height: 16px;
            margin: 0;
        }

        .col-md-7,
        .col-md-5 {
            float: left;
        }

        .icard .col-md-5 img {
            width: auto;
            height: 100px;
            margin-top: 15px;
        }

        .icard .col-md-7 h4 {
            font-family: sans-serif;
            font-size: 20px;
            border: solid 1px;
            padding: 5px 5px;
            border-radius: 5px;
            margin-top: 15px;
        }

        .icard .col-md-7 img {
            width: auto;
            margin-top: 15px;
            height: 40px;
        }

        .add {
            padding: 0;
        }

        .add img {
            width: 50%;
            margin: 0;
            height: auto;
            border: none;
        }
    </style>
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card mt-3">
                        <div class="card-header d-print-none">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <h4 class="page-title">User Profile</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-6 icard mb-3">
                                    <div class="row">
                                        <div class="col-md-7 col-7 col-sm-7">
                                            <img src="{{ asset('frontend/assets/images/logo/genial-logo.png')}}">
                                        </div>
                                        <div class="col-md-5 col-5 col-sm-5 text-right">
                                            <img src="@if(!empty(Auth::user()->profile_picture)){{asset('frontend/customer/'.Auth::user()->profile_picture)}}@else {{asset('frontend/assets/images/profile.jpg')}} @endif"
                                                alt="Not Available">
                                        </div>
                                    </div>
                                    <div class="usr">
                                        <ul style="padding-top: 18px; padding-bottom:39px">
                                            <li><b>Name:</b> {{Auth::user()->name}} </li>
                                            <li><b>ID No:</b> {{Auth::user()->referral_code}}</li>
                                            <li><b>Mob.No:</b> {{Auth::user()->phone}}</li>
                                            <li><b>Date of Join:</b> {{Auth::user()->created_at}}</li>
                                            <li><b>Address:</b> {{Auth::user()->address}}</li>
                                        </ul>
                                    </div>
                                    <img src="{{ asset('frontend/id.png')}}" alt="Not Available">
                                </div>
                                <div class="col-md-6 col-6 icard">
                                    <div class="row">
                                        <div class="col-md-7 col-7 col-sm-7">
                                            <h4 style="margin-top: 10px;border: none;">Signature of company's
                                                authorised person</h4>
                                        </div>
                                        <div class="col-md-5 col-5 col-sm-5 text-right">
                                            <img src="{{ asset('frontend/sign.png')}}"
                                                style="height: 40px" alt="Not Available">
                                        </div>
                                    </div>
                                    <div class="usr">
                                        <h5 style="font-family: sans-serif;">Genial Tour Pvt. Ltd.</h5>
                                        <ul>
                                            <li><b>Address:</b> 13A, Gopala Tower, Rajinder Place, New Delhi, West Delhi,
                                                Delhi, India - 110008</li>
                                            <li><b>Email:</b> genialtour2@gmail.com</li>
                                            <li><b>Reg. No.:</b> U74950DL2016PTC292039</li>
                                            <li><b>Contact:</b> +91 7678937678</li>
                                            <li><b>Website:</b> www.genialnet.in</li>
                                        </ul>
                                        <div class="add">
                                            <p><b>NOTE :</b> The direct seller is not authorised to collect any
                                                types of Cheque/Demand draft/Cash in his name from the customer</p>
                                        </div>
                                    </div>
                                    <img src="{{ asset('frontend/id.png')}}">
                                </div>
                            </div>
                            <div class="mt-4 mb-1">
                                <div class="text-end d-print-none">
                                    <a href="javascript:window.print()"
                                        class="btn btn-primary waves-effect waves-light me-1"><i
                                            class="mdi mdi-printer me-1"></i> Print</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script>
            img_input1.onchange = evt => {
                const [file] = img_input1.files
                if (file) {
                    img1.src = URL.createObjectURL(file)
                }
            }
        </script>
    @endsection
