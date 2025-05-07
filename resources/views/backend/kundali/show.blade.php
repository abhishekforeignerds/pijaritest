@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-6 m-auto">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">View Kundali</h6>

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{ $data->name }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $data->phone }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $data->dob }}</td>
                            </tr>
                            <tr>
                                <th>Time of Birth</th>
                                <td>{{ $data->tob }}</td>
                            </tr>
                            <tr>
                                <th>Place of Birth</th>
                                <td>{{ $data->pob }}</td>
                            </tr>
                            <tr>
                                <th>Language</th>
                                <td>{{ $data->language }}</td>
                            </tr>
                            <tr>
                                <th>PDF Type</th>
                                <td>{{ $data->pdf_type }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $data->address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
