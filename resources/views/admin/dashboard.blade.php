@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Overview</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <i class="fas fa-calendar"></i> Today
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Revenue</h6>
                        <h2 class="my-2">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h2>
                        <p class="card-text small"><i class="fas fa-arrow-up"></i> Dynamic data</p>
                    </div>
                    <i class="fas fa-wallet fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">New Orders</h6>
                        <h2 class="my-2">{{ $pesanan_baru }}</h2>
                        <p class="card-text small">{{ $pesanan_baru }} Needs Processing</p>
                    </div>
                    <i class="fas fa-shopping-bag fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-dark">
                        <h6 class="card-title mb-0">Total Menu</h6>
                        <h2 class="my-2">{{ $total_products }}</h2>
                        <p class="card-text small">Food & Beverages</p>
                    </div>
                    <i class="fas fa-utensils fa-2x opacity-50 text-dark"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-dark">
                        <h6 class="card-title mb-0">Customers</h6>
                        <h2 class="my-2">{{ $total_users }}</h2>
                        <p class="card-text small">Registered Members</p>
                    </div>
                    <i class="fas fa-users fa-2x opacity-50 text-dark"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Sales Chart (This Week)</h5>
            </div>
            <div class="card-body text-center py-2">
                <canvas id="salesChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Orders</h5>
            </div>
            <ul class="list-group list-group-flush" style="max-height: 260px; overflow-y: auto;">
                @foreach($recent_orders as $order)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $order->user->full_name }}</strong><br>
                            <small class="text-muted">{{ count($order->orderDetails) }} items (Rp {{ number_format($order->total_harga, 0, ',', '.') }})</small>
                        </div>
                        @if($order->status == 'paid')
                            <span class="badge bg-success rounded-pill">Completed</span>
                        @elseif($order->status == 'pending')
                            <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                        @else
                            <span class="badge bg-danger rounded-pill">Cancelled</span>
                        @endif
                    </li>
                @endforeach
                @if($recent_orders->count() == 0)
                    <li class="list-group-item text-center text-muted">No orders yet</li>
                @endif
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($sales_data['labels']) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($sales_data['data']) !!},
                    backgroundColor: 'rgba(139, 94, 60, 0.2)',
                    borderColor: 'rgba(139, 94, 60, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
