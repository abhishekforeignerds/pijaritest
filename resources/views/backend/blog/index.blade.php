@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-6">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <h6 class="card_title">Blog List</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $data)
                                        <tr>
                                            <td class="text-center">
                                                <img src="{{ $data->full_image_url }}" height="50px" width="70px">
                                            </td>
                                            <td>
                                                {{ $data->title }}
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" onchange="update_status(this)"
                                                        value="{{ $data->id }}" type="checkbox"
                                                        id="flexSwitchCheckChecked"
                                                        @if ($data->status == 1) {{ 'checked' }} @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex order-actions">
                                                    <a href="{{ route('blog.edit', $data->id) }}" class="me-2"><i
                                                            class="bx bxs-edit text-info"></i>
                                                    </a>
                                                    <form action="{{ route('blog.destroy', $data->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="">
                                                            <i class="bx bxs-trash text-danger"></i>
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
            <div class="col-6">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                @isset($edit)
                                    <h6 class="card_title">Edit Blog</h6>
                                @else
                                    <h6 class="card_title">Add Blog</h6>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @isset($edit)
                            <form action="{{ route('blog.update', $edit->id) }}" method="post" enctype="multipart/form-data"
                                id="update_form">
                                @method('put')
                            @else
                                <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data"
                                    id="add_form">
                                @endisset
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                            @isset($edit) value="{{ $edit->title }}" @endisset
                                            required>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">Title (Hindi)<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title_hindi" class="form-control"
                                            placeholder="Enter Title"
                                            @isset($edit) value="{{ $edit->title_hindi }}" @endisset
                                            required>
                                        @error('title_hindi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">Short Description <span
                                                class="text-danger">*</span></label>
                                        <textarea name="short_description" class="form-control" required>
                                            @isset($edit)
{{ $edit->short_description }}
@endisset
                                        </textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">Short Description (Hindi) <span
                                                class="text-danger">*</span></label>
                                        <textarea name="short_description_hindi" class="form-control" required>
                                                @isset($edit)
{{ $edit->short_description_hindi }}
@endisset
                                        </textarea>
                                        @error('short_description_hindi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"> Description <span class="text-danger">*</span></label>
                                        <textarea id="description" name="description" rows="8">
                                            @isset($edit)
{{ $edit->description }}
@endisset
                                        </textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"> Description (Hindi)<span
                                                class="text-danger">*</span></label>
                                        <textarea id="description_hindi" name="description_hindi" rows="8">
                                            @isset($edit)
{{ $edit->description_hindi }}
@endisset
                                        </textarea>
                                        @error('description_hindi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="image" class="form-label">Image <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input id="image" type="file" class="form-control" name="image"
                                                placeholder="Select Image...">
                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <small class="text-muted" id="sizeMessage">
                                            Please upload an image with dimensions 380x218 pixels.
                                        </small>
                                        <img class="mt-2" id="img"
                                            @isset($edit) src="{{ $edit->full_image_url }}"
                                            @else src="{{ asset('backend/images/no-image.jpg') }}" @endisset
                                            onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                            height="80px" width="80px">
                                    </div>
                                    @isset($edit)
                                        <div class="col-md-12 mt-3">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="submit" class="btn btn-primary px-4">Update</button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-12 mt-3">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                                            </div>
                                        </div>
                                    @endisset
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        image.onchange = evt => {
            const [file] = image.files
            if (file) {
                img.src = URL.createObjectURL(file)
            }
        }

        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#description_hindi'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('blog.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }
    </script>
@endsection
