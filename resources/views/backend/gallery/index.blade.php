@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
	<div class="page-wrapper">
			<div class="page-content">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col-6 col-xl-10">
							<h3>Gallery</h3>
							</div>
							<div class="col-6 col-xl-2">
								<a href="{{ route('gallery.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add Gallery</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table mb-0">
								<thead class="table-light">
									<tr>
										<th>#</th>
                                        <th>Image</th>
										<th>Title</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@php
									$i=1;
									@endphp
									@foreach ($gallery as $item)
									<tr>
										<td>{{$i++}}</td>
										<td><img src="../gallery/{{$item->image}}" style="width:150px;"></td>
										<td>{{$item->title}}</td>
                                        <td>
											<div class="d-flex order-actions">
												<a href="{{route('gallery.edit',$item->id)}}" class=""><i class='bx bxs-edit'></i></a>
												<a href="{{route('gallery.delete',$item->id)}}" class="ms-3"><i class='bx bxs-trash'></i></a>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>


			</div>
		</div>
    <!--end page wrapper -->
@endsection

