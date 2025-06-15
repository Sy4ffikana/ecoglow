@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Add New Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
    <label for="barcode" class="form-label">Barcode</label>
    <div class="input-group">
        <input type="text" name="barcode" id="barcode" class="form-control" value="{{ old('barcode', request('barcode')) }}" required>
        <button type="button" class="btn btn-outline-success" onclick="startScanner()">Scan</button>
    </div>
</div>

<!-- 🔴 Barcode scanner target -->
<div id="reader" style="width: 100%; max-width: 400px; margin-top: 20px;"></div>

        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" class="form-control" value="{{ old('category') }}" required>
        </div>

        <div class="mb-3">
            <label for="sustainable_rating" class="form-label">Sustainable Rating (%)</label>
            <input type="number" name="sustainable_rating" class="form-control" value="{{ old('sustainable_rating') }}" min="0" max="100" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="animal_cruelty" value="1" class="form-check-input" id="animal_cruelty"
                {{ old('animal_cruelty', $product->animal_cruelty ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="animal_cruelty">Cruelty Free</label>
        </div>


        <div class="mb-3">
            <label for="price" class="form-label">Price (RM)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label for="shop_url" class="form-label">Online Shop URL</label>
            <input type="url" class="form-control" name="shop_url" id="shop_url" value="{{ old('shop_url', $product->shop_url ?? '') }}">
        </div>


        <h5>Ingredients Analysis</h5>

        <div id="ingredients-container">
            <div class="ingredient-row row g-2 mb-2">
                <div class="col-md-4">
                    <input type="text" name="ingredients[0][ingredient]" class="form-control" placeholder="Ingredient" required>
                </div>
            <div class="col-md-4">
                <input type="text" name="ingredients[0][function]" class="form-control" placeholder="Function (optional)">
            </div>
            <div class="col-md-4">
                <select name="ingredients[0][safety]" class="form-select" required>
                    <option value="">Select Safety</option>
                    <option value="Worst">Worst</option>
                    <option value="Bad">Bad</option>
                    <option value="Okay">Okay</option>
                    <option value="Good">Good</option>
                    <option value="Great!">Great!</option>
                </select>
            </div>
        </div>
        </div>

        <!-- Add Ingredient button -->
        <div class="mb-3">
    <button type="button" class="btn btn-secondary" onclick="addIngredient()">+ Add Ingredient</button>
</div>

<div id="ingredient-container"></div>

@push('scripts')
<script>
    function addIngredient() {
        const container = document.getElementById('ingredient-container');
        const inputGroup = document.createElement('div');
        inputGroup.classList.add('input-group', 'mb-2');

        inputGroup.innerHTML = `
            <input type="text" name="ingredients[]" class="form-control" placeholder="Ingredient name" required>
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Remove</button>
        `;

        container.appendChild(inputGroup);
    }
</script>
@endpush


        <!-- Create Product button -->
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-success px-4">Create Product</button>
        </div>
    </form>
</div>

<!-- Scanner Modal -->
<div class="modal fade" id="scannerModal" tabindex="-1" aria-labelledby="scannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="scannerModalLabel">Scan Barcode</h5>
        <button type="button" class="btn-close" onclick="stopScanner()" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="reader" style="width: 100%;"></div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" defer></script>
<script>
let html5QrcodeScanner;

const startScanner = () => {
    html5QrcodeScanner = new Html5Qrcode("reader");
    html5QrcodeScanner.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: 250
        },
        (decodedText) => {
            html5QrcodeScanner.stop().then(() => {
                const userRole = "{{ Auth::user()->is_admin ? 'admin' : 'user' }}";

                if (userRole === 'admin') {
                    window.location.href = `/admin/products/create?barcode=${decodedText}`;
                } else {
                    window.location.href = `/products/search?barcode=${decodedText}`;
                }
            });
        },
        (error) => {
            // Ignore errors
        }
    );
};

const stopScanner = () => {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.stop().then(() => {
            html5QrcodeScanner.clear();
        });
    }
};

document.getElementById('scannerModal').addEventListener('shown.bs.modal', startScanner);
document.getElementById('scannerModal').addEventListener('hidden.bs.modal', stopScanner);
</script>
@endpush

@endsection
