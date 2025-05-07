@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-6">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <h6 class="card_title">Testimonial List</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Image</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Page</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($testimonials as $data)
                                        <tr>
                                            <td class="text-center">
                                                <img src="{{ $data->full_image_url }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('backend/images/no_image.png') }}'"
                                                    height="50px" width="70px">
                                            </td>
                                            <td>
                                                {{ $data->type }}
                                            </td>
                                            <td>
                                                {{ $data->name }}
                                            </td>
                                            <td>
                                                {{ $data->page }}
                                            </td>
                                            <td>
                                                <div class="d-flex order-actions">
                                                    <a href="{{ route('testimonial.edit', $data->id) }}" class="me-2"><i
                                                            class="bx bxs-edit text-info"></i>
                                                    </a>
                                                    <form action="{{ route('testimonial.destroy', $data->id) }}"
                                                        method="POST" style="display:inline;">
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
                                    <h6 class="card_title">Edit Testimonial</h6>
                                @else
                                    <h6 class="card_title">Add Testimonial</h6>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @isset($edit)
                            <form action="{{ route('testimonial.update', $edit->id) }}" method="post"
                                enctype="multipart/form-data" id="update_form">
                                @method('put')
                            @else
                                <form action="{{ route('testimonial.store') }}" method="post" enctype="multipart/form-data"
                                    id="add_form">
                                @endisset
                                @csrf

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="type" class="form-label">Page <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" aria-label="Default select example" name="page"
                                            >
                                            <option value="home"
                                                {{ isset($edit) && $edit->page == 'home' ? 'selected' : '' }}>Home</option>
                                            <option value="e_puja"
                                                {{ isset($edit) && $edit->page == 'e_puja' ? 'selected' : '' }}>E-Puja
                                            </option>
                                            <option value="pooja"
                                                {{ isset($edit) && $edit->page == 'pooja' ? 'selected' : '' }}>Pooja
                                            </option>
                                            <option value="terth_pooja"
                                                {{ isset($edit) && $edit->page == 'terth_pooja' ? 'selected' : '' }}>Terth Pooja
                                            </option>
                                        </select>
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="type" class="form-label">Type <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" aria-label="Default select example" name="type"
                                            id="type-select">
                                            <option value="Text"
                                                {{ isset($edit) && $edit->type == 'Text' ? 'selected' : '' }}>Text</option>
                                            <option value="Video"
                                                {{ isset($edit) && $edit->type == 'Video' ? 'selected' : '' }}>Video
                                            </option>
                                        </select>
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3" id="video-link-group" style="display: none;">
                                        <label for="link" class="form-label">Link <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="link" class="form-control" id="link"
                                            placeholder="Video Link"
                                            @isset($edit) value="{{ $edit->link }}" @endisset>
                                        @error('link')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div id="other-fields">
                                        <div class="col-md-12 mb-3">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Enter Name"
                                                @isset($edit) value="{{ $edit->name }}" @endisset>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="designation" class="form-label">Designation </label>
                                            <input type="text" name="designation" class="form-control"
                                                placeholder="Enter Designation"
                                                @isset($edit) value="{{ $edit->designation }}" @endisset>
                                            @error('designation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">Description <span class="text-danger">*</span></label>
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

                                        <div class="col-lg-12 mb-3">
                                            <label for="image" class="form-label">Image </label>
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
                                                Please upload an image with dimensions 96x96 pixels.
                                            </small>
                                            <img class="mt-2" id="img"
                                                @isset($edit) src="{{ $edit->full_image_url }}"
                                                    @else src="{{ asset('backend/images/no-image.jpg') }}" @endisset
                                                onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                                height="80px" width="80px">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                                        </div>
                                    </div>
                                </div>


                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('slider.update_status') }}', {
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type-select');
            const videoLinkGroup = document.getElementById('video-link-group');
            const otherFields = document.getElementById('other-fields');

            function toggleFields() {
                if (typeSelect.value === 'Video') {
                    videoLinkGroup.style.display = 'block';
                    otherFields.style.display = 'none';
                } else {
                    videoLinkGroup.style.display = 'none';
                    otherFields.style.display = 'block';
                }
            }

            toggleFields();

            typeSelect.addEventListener('change', toggleFields);
        });
    </script>
@endsection
