@extends('master')

@section('content')
    <!-- Content -->
    <div class="container col-sm-5 col-md-6 col-lg-9 col-xxl-10 pb-6">

        <!-- Laptop Grid -->
        <div class="container-fluid px-3">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @foreach ($assignedSubjects as $subject)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm laptop-card">
                            <div class="position-relative bg-light rounded-top" style="height: 200px">
                                <img class="card-img-top p-3" src="images/chameleon.png" alt="Default Image"
                                    style="height: 200px; object-fit: contain;">
                            </div>

                            <div class="card-body p-3">
                                <a href="{{ route('viewListStudent', ['classroom_id' => $subject->classroom->id]) }}"
                                    class="nav-link">
                                    <h5 class="card-title fw-semibold text-truncate mb-3">
                                        {{ $subject->classroom->year }} {{ $subject->classroom->name }}
                                    </h5>
                                </a>

                                <div class="specs-list">
                                    <div class="spec-item d-flex align-items-center mb-2">
                                        <span>{{ $subject->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
