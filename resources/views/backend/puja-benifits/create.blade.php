@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-12 m-auto">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">{{ !empty($data->id) ? 'Edit' : 'Add' }} Puja Benifits</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post"
                            action="{{ !empty($data->id) ? route('puja-benifits.update', $data->id) : route('puja-benifits.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (!empty($data->id))
                                @method('PUT')
                            @endif
                            <div class="form-body row mt-4">
                                <div class="col-lg-12">
                                    <div class="border border-3 p-4 rounded">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="bsValidation1" class="form-label">Product<span>*</span></label>
                                                <select name="product_id" class="form-control">
                                                    @foreach ($product_data as $product)
                                                        <option value="{{ $product->id }}" selected>
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="bsValidation1" class="form-label">Title<span>*</span></label>
                                                <input type="text" class="form-control" name="title" id="bsValidation1"
                                                    placeholder="Enter Title" value="{{ old('title', $data->title ?? '') }}"
                                                    required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="bsValidation1" class="form-label">Title Hindi<span>*</span></label>
                                                <input type="text" class="form-control" name="title_hindi" id="bsValidation1"
                                                    placeholder="Enter Title" value="{{ old('title_hindi', $data->title_hindi ?? '') }}"
                                                    required>
                                            </div>
                                            <div class="col-md-12  mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea id="text_editor" name="description">{{ old('description', $data->description ?? '') }}</textarea>
                                            </div>
                                            <div class="col-md-12  mb-3">
                                                <label for="description_hindi" class="form-label">Description Hindi</label>
                                                <textarea id="description_hindi" name="description_hindi">{{ old('description_hindi', $data->description_hindi ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">
                                            {{ !empty($data->id) ? 'Update' : 'Submit' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Puja Benifits List</h6>
                            </div>
                            <div class="ms-auto">

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($puja_benifit as $data)
                                        <tr>
                                            <td>{{ $data->title }}</td>
                                            <td>
                                                <div class="d-flex order-actions">
                                                    <a href="{{ route('puja-benifits.edit', $data->id) }}" class="me-2"><i
                                                            class="bx bxs-edit"></i></a>
                                                    <form action="{{ route('puja-benifits.destroy', $data->id) }}"
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
@endsection
@section('script')
    <script>
        ClassicEditor
            .create(document.querySelector('#text_editor'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#description_hindi'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
