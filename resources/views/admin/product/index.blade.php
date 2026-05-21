@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
    <h2>Menu List</h2>
    <a href="{{ url('/admin/product/create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Menu
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Photo</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($products->count() > 0)
                        @foreach($products as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('assets/img/products/'.$row->foto) }}" alt="Foto" class="rounded" width="50" height="50" style="object-fit: cover;">
                                </td>
                                <td class="fw-bold">{{ htmlspecialchars($row->nama_produk) }}</td>
                                <td>
                                    @if($row->kategori == 'makanan')
                                        <span class="badge bg-warning text-dark">Food</span>
                                    @else
                                        <span class="badge bg-info text-dark">Drink</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($row->harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($row->stok < 5)
                                        <span class="text-danger fw-bold">{{ $row->stok }} (Low)</span>
                                    @else
                                        {{ $row->stok }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/admin/product/edit/'.$row->id) }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                                    <a href="{{ url('/admin/product/delete/'.$row->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this menu?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No menu data available.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
