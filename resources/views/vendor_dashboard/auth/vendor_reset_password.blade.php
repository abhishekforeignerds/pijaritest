<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('backend/images/favicon-32x32.png')}}')}}" type="image/png" />
	<!-- loader-->
	<link href="{{ asset('backend/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{ asset('backend/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ asset('backend/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="{{ asset('backend/css/app.css')}}" rel="stylesheet">
	<link href="{{ asset('backend/css/icons.css')}}" rel="stylesheet">
    <title>Genial Admin | Dashboard</title>
</head>

<body class="">
	<!--wrapper-->
    <div class="wrapper">
		<div class="authentication-reset-password d-flex align-items-center justify-content-center">
		 <div class="container">
			<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
				<div class="col mx-auto">
					<div class="card">
						<div class="card-body">
							<div class="p-4">
								<div class="mb-4 text-center">
									<img src="{{ asset('backend/images/logo-icon.png')}}" width="60" alt="" />
								</div>
								<div class="text-start mb-4">
									<h5 class="text-center">Genrate New Password</h5>
									<p class="mb-0 text-center">We received your reset password request. Please enter your new password!</p>
								</div>
								<div class="mb-3 mt-4">
									<label class="form-label">New Password<span>*</span></label>
									<input type="text" class="form-control" placeholder="Enter new password" />
								</div>
								<div class="mb-4">
									<label class="form-label">Confirm Password<span>*</span></label>
									<input type="text" class="form-control" placeholder="Confirm password" />
								</div>
								<div class="d-grid gap-2">
									<button type="button" class="btn btn-primary">Change Password</button> <a href="#" class="btn btn-light"><i class='bx bx-arrow-back mr-1'></i>Back to Login</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		  </div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{ asset('backend/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{ asset('backend/js/jquery.min.js')}}"></script>
	<script src="{{ asset('backend/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{ asset('backend/plugins/metismenu/js/metisMenu.min.js')}}"></script>
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
