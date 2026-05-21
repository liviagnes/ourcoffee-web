@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Menu</h2>
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

        <form action="{{ url('/admin/product/update/'.$product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Menu Name</label>
                <input type="text" name="nama_produk" class="form-control" required value="{{ old('nama_produk', $product->nama_produk) }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Category</label>
                    <select name="kategori" class="form-select">
                        <option value="makanan" {{ (old('kategori', $product->kategori) == 'makanan') ? 'selected' : '' }}>Food</option>
                        <option value="minuman" {{ (old('kategori', $product->kategori) == 'minuman') ? 'selected' : '' }}>Drink</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Stock</label>
                    <input type="number" name="stok" class="form-control" required value="{{ old('stok', $product->stok) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Price (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="harga" class="form-control" required value="{{ old('harga', $product->harga) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Product Photo (Leave blank if unchanged)</label>
                <br>
                <img src="{{ asset('assets/img/products/'.$product->foto) }}" alt="Photo" width="100" class="mb-2 rounded">
                <input type="file" name="foto" class="form-control" accept=".jpg, .jpeg, .png">
                <div class="form-text text-muted">Format: JPG/PNG. Max 2MB.</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Short Description</label>
                <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">Update Product</button>
                <a href="{{ url('/admin/product') }}" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
