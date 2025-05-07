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
                            <h6 class="card_title">Page List</h6>
                        </div>
                        <div class="col-lg-8">
                            <div class="top_search">
                                <a href="{{ route('pages.create') }}" class="btn btn-custom radius-30 mt-2 mt-lg-0">
                                    <i class="bx bxs-plus-square"></i>
                                    Add Page
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>Slug</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pages as $page)
                                <tr>
                                    <td>{{ $page->slug }}</td>
                                    <td>{{ $page->title }}</td>
                                    <td>{{ Str::limit($page->description, 60) }}</td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="{{ route('pages.edit', $page->id) }}" class="me-2">
                                                <i class="bx bxs-edit text-info"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="me-2"
                                                onclick="confirmDelete('{{ route('pages.destroy', $page->id) }}')">
                                                <i class="bx bxs-trash text-danger"></i>
                                            </a>
                                            <form id="delete-form-{{ $page->id }}"
                                                action="{{ route('pages.destroy', $page->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">No pages found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $pages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--end page wrapper -->

<script>
    function confirmDelete(url) {
            if (confirm('Are you sure you want to delete this page?')) {
                const formId = 'delete-form-' + url.split('/').pop();
                document.getElementById(formId).submit();
            }
        }
</script>
@endsection