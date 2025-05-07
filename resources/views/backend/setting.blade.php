@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <form method="POST" action="{{ route('admin.setting.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Setting</h6>
                            </div>
                            <div class="ms-auto"><button type="submit"
                                    class="btn btn-primary radius-30 mt-2 mt-lg-0">Update</button></div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-body row mt-4">
                            <div class="col-lg-12">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputProductTitle" class="form-label">GP Commission Percentage Product<span>*</span></label>
                                            <input type="hidden" name="types[]" value="gv_comission_percentage_product">
                                            <input type="number" class="form-control" name="gv_comission_percentage_product" id="gv_comission_percentage_product"
                                                placeholder="Enter GP Commission Percentage Product"  value="{{ get_setting('gv_comission_percentage_product') }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="inputProductTitle" class="form-label">GP Commission Percentage Service<span>*</span></label>
                                            <input type="hidden" name="types[]" value="gv_comission_percentage_service">
                                            <input type="number" class="form-control" name="gv_comission_percentage_service" id="gv_comission_percentage_service"
                                                placeholder="Enter GP Commission Percentage Service"  value="{{ get_setting('gv_comission_percentage_service') }}" required>
                                        </div>

                                    </div>

                            </div>
                        </div>

                        <!--end row-->
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
