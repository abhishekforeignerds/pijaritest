@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card border-0 rounded-lg text-center mt-4" style="max-width: 400px; margin: auto;">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">User Profile</h5>
                </div>
                <div class="card-body">
                    <div class="profile-img mb-3">
                        @if ($user->profile_picture)
                            <img src="{{ uploaded_asset($user->profile_picture) }}" alt="Profile Picture"
                                class="rounded-circle img-fluid border"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <img src="{{ asset('backend/images/avatars/admin.png') }}" alt="Default Avatar"
                                class="rounded-circle img-fluid border"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @endif
                    </div>
                    <h4 class="fw-bold text-danger">{{ $user->name }}</h4>
                    <p class="text-muted mb-2">Email: <span class="text-dark">{{ $user->email }}</span></p>
                    <p class="text-muted mb-2">Phone: <span class="text-dark">{{ $user->phone }}</span></p>
                    <p class="text-muted mb-2">Address: <span class="text-dark">{{ $user->address ?? '--' }}</span></p>
                </div>
                {{-- <div class="card-footer bg-light">
                    <a href="#" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i> Edit
                        Profile</a>
                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt"></i>
                        Logout</a>
                </div> --}}
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
