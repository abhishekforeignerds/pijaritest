@extends('backend.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <h6 class="card_title">Sorting Settings</h6>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('sorting.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="model" value="Product">

                    <div class="mb-3">
                        <label class="form-label">Sort Column:</label>
                        <select name="sort_column" class="form-control">
                            <option value="name" {{ $setting->sort_column == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="name_hindi" {{ $setting->sort_column == 'name_hindi' ? 'selected' : ''
                                }}>Name Hindi
                            </option>

                        </select>
                        {{-- <select name="sort_column" class="form-control">
                            @foreach($columns as $column)
                            <option value="{{ $column }}" {{ $setting->sort_column == $column ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $column)) }}
                            </option>
                            @endforeach
                        </select> --}}
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sort Direction:</label>
                        <select name="sort_direction" class="form-control">
                            <option value="asc" {{ $setting->sort_direction == 'asc' ? 'selected' : '' }}>Ascending
                            </option>
                            <option value="desc" {{ $setting->sort_direction == 'desc' ? 'selected' : '' }}>Descending
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-custom radius-30">Update Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection