@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-12 m-auto">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <a href="{{ route('pages.index') }}" class="btn btn-link">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                        <div>
                            <h6 class="card_title">{{ $page->exists ? 'Edit' : 'Add' }} Page</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST"
                        action="{{ $page->exists ? route('pages.update', $page) : route('pages.store') }}">
                        @csrf
                        @if ($page->exists)
                        @method('PUT')
                        @endif

                        <div class="form-body row mt-4">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="slug" class="form-label">Slug <span>*</span></label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                placeholder="Enter page slug" value="{{ old('slug', $page->slug) }}">
                                            @error('slug')
                                            <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="title" class="form-label">Title <span>*</span></label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                placeholder="Enter page title" value="{{ old('title', $page->title) }}">
                                            @error('title')
                                            <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="3"
                                                placeholder="Enter page description">{{ old('description', $page->description) }}</textarea>
                                            @error('description')
                                            <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- <div class="col-md-12 mb-3">
                                            <label for="content" class="form-label">Content</label>
                                            <textarea class="form-control" name="content" id="content" rows="6"
                                                placeholder="Enter full page content">{{ old('content', $page->content) }}</textarea>
                                            @error('content')
                                            <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-custom">
                                        {{ $page->exists ? 'Update' : 'Submit' }}
                                    </button>
                                    <a href="{{ route('pages.index') }}" class="btn btn-secondary">Cancel</a>
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