<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('backend/images/favicon-32x32.png')}}" type="image/png" />
	<!-- Bootstrap CSS -->
	<link href="{{ asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ asset('backend/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="{{ asset('backend/css/app.css')}}" rel="stylesheet">
	<link href="{{ asset('backend/css/icons.css')}}" rel="stylesheet">
	<title>Genial | Admin Dashboard</title>
</head>

<body class="">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="card mb-0">
							<div class="card-body">
								<div class="p-4">
									<div class="mb-3 text-center">
                                        <img src="{{ asset('frontend/assets/images/logo/genial-logo.png') }}" height="60"
                                        alt="" />
									</div>
									<div class="text-center mb-4">
										<h5 class="">Genial Vendor</h5>
										<p class="mb-0">Please log in to your account</p>
									</div>
									<div class="form-body">
										<form class="row g-3" name="vendor_login" method="post" action="{{route('vendor.login')}}">
                                            @csrf
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Vendor Code<span>*</span></label>
												<input type="text" class="form-control" name="vendor_code" maxlength="9" onKeyPress="if(this.value.length==9) return false;" id="inputEmailAddress" placeholder="Enter Vendor Code" value="{{old('vendor_code')}}">
                                                <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                                    <strong>{{ $errors->first('vendor_code') }}</strong>
                                                </span>
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Password<span>*</span></label>
												<div class="input-group" id="show_hide_password">
													<input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword"  placeholder="Enter Password" value="{{old('password')}}"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
                                                <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
											</div>
											<div class="col-md-12">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
												</div>
											</div>
											{{-- <div class="col-md-6 text-end">	<a href="#">Forgot Password ?</a> --}}
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary">Sign in</button>
												</div>
											</div>
											<div class="col-12">
												<div class="text-center ">
													<p class="mb-0">Don't have an account yet? <a href="{{route('vendor_register')}}">Sign up here</a>
													</p>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{ asset('backend/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{ asset('backend/js/jquery.min.js')}}"></script>
	<script src="{{ asset('backend/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="{{ asset('backend/js/app.js')}}"></script>
</body>
</html>
