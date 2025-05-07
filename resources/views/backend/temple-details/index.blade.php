@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Temple List</h6>
                            </div>
                            {{-- <div class="ms-auto">
                                <a href="{{ route('temple-details.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                                    <i class="bx bxs-plus-square"></i>
                                    Add temple details
                                </a>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Icon</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($temple_list as $data)
                                        <tr>
                                            <td>
                                                @if ($data->image)
                                                    <img src="{{ uploaded_asset($data->image) }}" alt="Icon"
                                                        style="width: 50px; height: 50px;">
                                                @else
                                                    <span>No image</span>
                                                @endif
                                            </td>
                                            <td>{{ $data->title }}</td>
                                            <td>
                                                <div class="d-flex order-actions">
                                                    <a href="{{ route('temple-details.edit', $data->id) }}"
                                                        class="me-2"><i class="bx bxs-edit"></i></a>
                                                    <form action="{{ route('temple-details.destroy', $data->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">
                                                            <i class="bx bxs-trash"></i>
                                                        </button>
                                                    </form>
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
