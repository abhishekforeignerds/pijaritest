@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Reward</h6>
                            </div>
                            <div class="ms-auto"><a href="{{ route('admin.give_reward') }}"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0">Generate Reward</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                                <tr>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">Reward</th>
                                    <th scope="col">Total GP</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($rewards as $key=>$reward)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $reward->reward }}</td>
                                        <td>{{ $reward->total_gp }}</td>
                                    </tr>
                                @empty
                                    <tr class="footable-empty">
                                        <td colspan="11">
                                            <center style="padding: 70px;"><i class="far fa-frown"
                                                    style="font-size: 100px;"></i><br>
                                                <h2>Nothing Found</h2>
                                            </center>
                                        </td>
                                    </tr>
                                @endforelse
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

    </script>
@endsection
