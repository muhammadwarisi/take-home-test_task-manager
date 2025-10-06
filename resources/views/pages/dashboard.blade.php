@extends('layouts.app')
@section('content')
    <!-- Tasks Widget -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title mb-3">Total Tasks</h5>
                    <span class="display-6 fw-bold">{{$totalTasks}}</span>
                    <div class="text-muted mt-2">Semua Tugas</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title mb-3">Selesai</h5>
                    <span class="display-6 fw-bold">{{$completedTasks}}</span>
                    <div class="text-muted mt-2">Selesai</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title mb-3">Belum Selesai</h5>
                    <span class="display-6 fw-bold">{{$pendingTasks}}</span>
                    <div class="text-muted mt-2">Belum Selesai</div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Tasks Widget -->
@endsection
