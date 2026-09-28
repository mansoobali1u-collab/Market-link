@extends('layouts.customer')

@section('title', 'Farmers — MarketLink')

@section('content')

<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Farmers</h2>

            <p class="text-muted mb-0">
                Discover farmers and explore their products.
            </p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-outline-success">
            <i class="bi bi-arrow-left"></i>
            Dashboard
        </a>

    </div>


    {{-- Search --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <form method="GET"
                  action="{{ route('customer.farmers.index') }}">

                <div class="row g-3">

                    <div class="col-md-9">

                        <label class="form-label fw-semibold">
                            Search Farmers
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Search farmer by name or email..."
                            >

                        </div>

                    </div>


                    <div class="col-md-3 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-success w-100"
                        >
                            <i class="bi bi-search"></i>
                            Search
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Farmers --}}
    <div class="row g-4">

        @forelse ($farmers as $farmer)

            <div class="col-sm-6 col-lg-4">

                <div class="card h-100 border-0 shadow-sm farmer-card">

                    {{-- Farmer Avatar --}}
                    <div class="farmer-avatar">

                        @if ($farmer->profile_photo_path)

                            <img
                                src="{{ asset('storage/' . $farmer->profile_photo_path) }}"
                                alt="{{ $farmer->name }}"
                            >

                        @else

                            <div class="avatar-placeholder">
                                <i class="bi bi-person-fill"></i>
                            </div>

                        @endif

                    </div>


                    {{-- Farmer Information --}}
                    <div class="card-body text-center">

                        <span class="badge bg-light text-success mb-2">
                            <i class="bi bi-person-badge"></i>
                            Farmer
                        </span>


                        <h5 class="fw-bold mb-1">
                            {{ $farmer->name }}
                        </h5>


                        <p class="text-muted small mb-3">
                            <i class="bi bi-envelope"></i>
                            {{ $farmer->email }}
                        </p>


                        @if ($farmer->phone)

                            <p class="text-muted small mb-3">
                                <i class="bi bi-telephone"></i>
                                {{ $farmer->phone }}
                            </p>

                        @endif


                        @if ($farmer->address)

                            <p class="text-muted small mb-3">
                                <i class="bi bi-geo-alt"></i>
                                {{ $farmer->address }}
                            </p>

                        @endif


                        <a
                            href="{{ route('customer.farmers.show', $farmer->id) }}"
                            class="btn btn-success w-100"
                        >
                            View Farmer
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <i class="bi bi-people display-3 text-muted"></i>

                        <h4 class="fw-bold mt-3">
                            No farmers found
                        </h4>

                        <p class="text-muted mb-0">
                            Try searching for another farmer.
                        </p>

                    </div>

                </div>

            </div>

        @endforelse

    </div>


    {{-- Pagination --}}
    @if ($farmers->hasPages())

        <div class="mt-4 d-flex justify-content-center">

            {{ $farmers->links('pagination::bootstrap-5') }}

        </div>

    @endif

</div>


<style>

.farmer-card {
    border-radius: 12px;
    overflow: hidden;
    transition: 0.2s ease;
}

.farmer-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.10) !important;
}

.farmer-avatar {
    height: 180px;
    background: #f1f3f2;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.farmer-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: #198754;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 50px;
}

</style>

@endsection
