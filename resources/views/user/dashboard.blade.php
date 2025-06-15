@extends('layouts.app')

@section('content')
<style>
    .dashboard-top-products {
    text-align: center;
    margin-top: 30px;
    padding: 0 15px;
}

.dashboard-top-products h2 {
    font-family: 'Georgia', serif;
    font-size: 28px;
    margin-bottom: 25px;
    color: #2f4f2f;
}

.dashboard-podium {
    display: flex;
    justify-content: center;
    align-items: flex-end;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 40px;
}

.dashboard-place {
    width: 140px;
    background-color: #f0fdf4;
    border-radius: 20px 20px 0 0;
    padding: 12px 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    font-family: 'Georgia', serif;
    transition: transform 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 240px; /* prevent cutoff */
}

.dashboard-place:hover {
    transform: translateY(-5px);
}

.dashboard-place img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    background-color: white;
    padding: 4px;
    margin-bottom: 8px;
}

.dashboard-first { margin-top: 0; }
.dashboard-second { margin-top: 40px; }
.dashboard-third { margin-top: 60px; }


.dashboard-place meter {
    width: 100%;
    height: 10px;
    display: block;
    margin-top: 4px;
    margin-bottom: 2px;
}

.dashboard-place .brand {
    font-weight: bold;
    font-size: 14px;
}

.dashboard-place .name {
    font-size: 12px;
    margin-bottom: 4px;
}

.dashboard-place .rating {
    font-size: 11px;
    color: #555;
}

@media (max-width: 768px) {
    .dashboard-podium {
        flex-direction: column;
        align-items: center;
    }

    .dashboard-place {
        width: 80%;
        min-height: auto;
        margin-bottom: 20px;
    }
}

    .scan-list {
        background-color: rgba(255,255,255,0.8);
        border-radius: 12px;
        padding: 20px;
        font-family: 'Georgia', serif;
    }

    .custom-button {
        display: block;
        background-color: #6b8e23;
        color: white;
        font-size: 1.25rem;
        padding: 12px 0;
        border: none;
        border-radius: 10px;
        font-family: 'Georgia', serif;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: background-color 0.3s ease;
    }

    .custom-button:hover {
        background-color: #5a7a1f;
        color: white;
        text-decoration: none;
    }

    
</style>

<div class="container mt-4">
    <h2 class="text-center mb-5" style="font-family: 'Georgia';">User Dashboard</h2>

    <!-- 🏆 Standardized Top 3 Products -->
<div class="dashboard-top-products">
    <h2>🏆 Top 3 Sustainable Products This Week</h2>
    <div class="dashboard-podium">
        @foreach ($topProducts as $index => $product)
            @php
                $placeClass = ['dashboard-second', 'dashboard-first', 'dashboard-third'][$index];
                $medal = ['🥈', '🥇', '🥉'][$index];
            @endphp
            <div class="dashboard-place {{ $placeClass }}">
                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark w-100">
                    <div class="text-center" style="font-size: 20px;">{{ $medal }}</div>

                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                    @endif

                    <div class="mt-2 px-1 w-100">
                        <div class="brand">{{ $product->brand }}</div>
                        <div class="name">{{ $product->name }}</div>
                        <meter min="0" max="100" value="{{ $product->sustainable_rating }}"></meter>
                        <div class="rating">{{ $product->sustainable_rating }}/100</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>


    <!-- 🔍 Search and History -->
    <div class="row scan-list mt-5">
        <div class="col-md-6">
            <h4>🕓 Latest Product History</h4>
            @if($latestHistory)
                <p>Latest product scanned: <strong>{{ $latestHistory->product->name }}</strong></p>
            @else
                <p>No product history found.</p>
            @endif
        </div>

        <div class="col-md-6 d-flex flex-column align-items-start justify-content-center">
            <!-- 📷 Scanner Button -->
            <div class="mb-3 w-100">
                <button class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#scannerModal">
                    𝄃𝄃𝄂𝄂𝄀𝄁𝄃𝄂𝄂𝄃 Scan Product
                </button>
            </div>

            <!-- 🔍 Search Bar -->
            <div class="w-100">
                <form action="{{ route('search') }}" method="GET" class="d-flex">
                    <input 
                        type="text" 
                        name="query" 
                        class="form-control me-2" 
                        placeholder="🔍 Search product by name, brand, or barcode..." 
                        style="font-family: 'Georgia'; background-color: #f8f9f9;" 
                        required
                    >
                    <button type="submit" class="btn btn-success">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 📷 Barcode Scanner Modal -->
<div class="modal fade" id="scannerModal" tabindex="-1" aria-labelledby="scannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4">
            <h5 class="text-center mb-3">Scan Product Barcode</h5>
            <div id="reader" style="width: 100%;"></div>
            <div class="text-center mt-3">
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- 🔌 Scripts -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    let html5QrcodeScanner;

    function startScanner() {
        html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            (decodedText) => {
                html5QrcodeScanner.stop().then(() => {
                    fetch('/scan', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ barcode: decodedText })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else if (data.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.error,
                                confirmButtonColor: '#6ab04c',
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Scan Failed',
                            text: 'Something went wrong. Please try again.',
                        });
                    });
                });
            },
            (errorMessage) => {
                // Optional: log error
            }
        ).catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Camera Error',
                text: 'Cannot access the camera. Please check permissions.',
            });
        });
    }

    function stopScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                html5QrcodeScanner.clear();
            });
        }
    }

    document.getElementById('scannerModal').addEventListener('shown.bs.modal', startScanner);
    document.getElementById('scannerModal').addEventListener('hidden.bs.modal', stopScanner);
</script>
@endpush

@if(session('scan_error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session("scan_error") }}',
        });
    </script>
@endif

@endsection
