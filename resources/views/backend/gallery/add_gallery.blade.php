@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
			<div class="page-content">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col-lg-12 col-xl-10">
							<h3>Add Gallery</h3>
							</div>
						</div>
					</div>
					<div class="card-body p-4">
						<div class="form-body mt-4">
							<div class="border border-3 p-4 rounded">
								<form method="post" action="{{route('gallery.store')}}" enctype="multipart/form-data">
							    @csrf

									<div class="row">
                                        <div class="col-lg-6 mb-3">
											<label for="formFile" class="form-label">Title</label>
											<input class="form-control" type="text" name="title" placeholder="Enter Title" required="">
										</div>
										<div class="col-lg-6 mb-3">
											<label for="formFile" class="form-label">Image</label>
											<input class="form-control" type="file" name="image" id="formFile" required="">
										</div>
									</div>
									<div class="col">
										<button type="submit" class="btn btn-primary px-5 radius-30">Save</button>
									</div>
								</form>
							</div>
							<!--end row-->

						</div>
					</div>
				</div>


			</div>
		</div>
@endsection
