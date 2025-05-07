@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-12 m-auto">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">{{ !empty($data->id) ? 'Edit' : 'Add' }} Temple Details</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post"
                            action="{{ !empty($data->id) ? route('temple-details.update', $data->id) : route('temple-details.store') }}"
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
                                                        <option value="{{ $product->id }}" selected> {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('product_id')
                                                    <small class="error text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="bsValidation1" class="form-label">Title<span>*</span></label>
                                                <input type="text" class="form-control" name="title" id="bsValidation1"
                                                    placeholder="Enter Title"
                                                    value="{{ old('title', $data->title ?? '') }}">
                                                @error('title')
                                                    <small class="error text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="bsValidation1" class="form-label">Title
                                                    Hindi<span>*</span></label>
                                                <input type="text" class="form-control" name="title_hindi"
                                                    id="bsValidation1" placeholder="Enter Title Hindi"
                                                    value="{{ old('title_hindi', $data->title_hindi ?? '') }}">
                                                @error('title_hindi')
                                                    <small class="error text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="bsValidation2" class="form-label">Image <span>*</span></label>
                                                <input type="file" class="form-control" id="Icon" name="image">
                                                <small class="text-muted"> Please upload an image with dimensions 500x500
                                                    pixels.
                                                </small>
                                                <img id="frame" src="{{ !empty($data->image) ? $data->image : '' }}"
                                                    style="{{ !empty($data->image) ? 'display:block' : 'display:none' }}"
                                                    width="100px" height="100px" />
                                                @error('image')
                                                    <small class="error text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-12  mb-3">
                                                <label for="description" class="form-label">Description
                                                    <span>*</span></label>
                                                <textarea id="text_editor" name="description">{{ old('description', $data->description ?? '') }}</textarea>
                                                @error('description')
                                                    <small class="error text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-12  mb-3">
                                                <label for="description_hindi" class="form-label">Description
                                                    Hindi<span>*</span></label>
                                                <textarea id="description_hindi" name="description_hindi">{{ old('description_hindi', $data->description_hindi ?? '') }}</textarea>
                                                @error('description_hindi')
                                                    <small class="error text-danger">{{ $message }}</small>
                                                @enderror
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
                <div class="card card-body">
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
                                                <a href="{{ route('temple-details.edit', $data->id) }}" class="me-2"><i
                                                        class="bx bxs-edit"></i></a>
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
