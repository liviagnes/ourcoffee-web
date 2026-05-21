@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Add New Menu</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/admin/product/store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Menu Name</label>
                <input type="text" name="nama_produk" class="form-control" required placeholder="Example: Kopi Susu Aren" value="{{ old('nama_produk') }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Category</label>
                    <select name="kategori" class="form-select">
                        <option value="makanan">Food</option>
                        <option value="minuman">Drink</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Initial Stock</label>
                    <input type="number" name="stok" class="form-control" value="10" min="1" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Price (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="harga" class="form-control" required placeholder="15000" value="{{ old('harga') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Product Photo</label>
                <input type="file" name="foto" class="form-control" required accept=".jpg, .jpeg, .png">
                <div class="form-text text-muted">Format: JPG/PNG. Max 2MB.</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Short Description</label>
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Describe the taste of this menu...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">Save Product</button>
                <a href="{{ url('/admin/product') }}" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
