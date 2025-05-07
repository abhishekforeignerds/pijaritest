@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <h6 class="card_title">Pujari List</h6>
                            </div>
                            <div class="col-lg-8">
                                <div class="top_search">
                                    <a href="{{ route('our_pujari.create') }}"
                                        class="btn btn-custom radius-30 mt-2 mt-lg-0">
                                        <i class="bx bxs-plus-square"></i>
                                        Add Pujari
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>City</th>
                                        <th>Experince</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pujari_list as $data)
                                        <tr>
                                            <td>
                                                @if ($data->image)
                                                    <img src="{{ uploaded_asset($data->image) }}" alt="Icon"
                                                        style="width: 50px; height: 50px;">
                                                @else
                                                    <span>No image</span>
                                                @endif
                                            </td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->city }}</td>
                                            <td>{{ $data->exp }} Years</td>
                                            <td>
                                                <div class="d-flex order-actions">
                                                    <a href="{{ route('our_pujari.edit', $data->id) }}" class="me-2"><i
                                                            class="bx bxs-edit text-info"></i></a>
                                                    <a href="javascript:void(0);" class="me-2"
                                                        onclick="confirmDelete('{{ route('our_pujari.delete', $data->id) }}')">
                                                        <i class="bx bxs-trash text-danger"></i>
                                                    </a>
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
    </div>
    <!--end page wrapper -->
@endsection
