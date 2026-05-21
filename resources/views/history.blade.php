@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/history.css') }}">
@endsection

@section('content')
<section class="history-section">
    <div class="container">
        <h2 class="fw-bold mb-4" style="color: #4a3228;">Order History</h2>

        @if($orders->count() > 0)
            <div class="row">
                <div class="col-lg-8">
                    @foreach($orders as $row)
                        @php
                            $status_class = 'status-pending';
                            $badge_color = 'bg-warning text-dark';
                            $status_label = 'Pending Payment';

                            if ($row->status == 'paid') {
                                $status_class = 'status-paid';
                                $badge_color = 'bg-success';
                                $status_label = 'Completed';
                            } elseif ($row->status == 'cancelled') {
                                $status_class = 'status-cancelled';
                                $badge_color = 'bg-danger';
                                $status_label = 'Cancelled';
                            }
                        @endphp
                        <div class="history-card">
                            <div class="status-line {{ $status_class }}"></div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <div class="order-date mb-1">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ date('d M Y, H:i', strtotime($row->created_at)) }}
                                    </div>
                                    <div class="order-code">
                                        {{ $row->kode_pesanan }}
                                        <span class="badge {{ $badge_color }} ms-2 text-white badge-status">
                                            {{ $status_label }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="small text-muted">Total Amount</div>
                                    <div class="total-price">Rp {{ number_format($row->total_harga, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    Method:
                                    <strong>
                                        {{ ($row->payment_method == 'qris') ? 'QRIS / Online' : 'Pay at Cashier' }}
                                    </strong>
                                    @if(!empty($row->no_meja))
                                        | Table: <strong>{{ $row->no_meja }}</strong>
                                    @endif
                                </div>
                                <div class="d-flex gap-2">
                                    @if($row->status == 'pending' && $row->payment_method == 'qris' && !empty($row->snap_token))
                                        <button type="button" class="btn-detail btn-pay-now" data-snap="{{ $row->snap_token }}" data-id="{{ $row->id }}" style="background: #00A5CF; color: #fff; border-color: #00A5CF;">
                                            <i class="fas fa-wallet me-1"></i> Pay Now
                                        </button>
                                    @endif
                                    <a href="{{ url('/order_success?code='.$row->kode_pesanan) }}" class="btn-detail">
                                        <i class="fas fa-receipt me-1"></i> View Receipt
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-history fa-4x text-muted mb-3 opacity-25"></i>
                <h4 class="text-muted">No order history yet</h4>
                <a href="{{ url('/menu') }}" class="btn btn-outline-dark rounded-pill mt-3">Order Now</a>
            </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.querySelectorAll('.btn-pay-now').forEach(function(button) {
        button.addEventListener('click', function() {
            var snapToken = this.getAttribute('data-snap');
            var orderId = this.getAttribute('data-id');

            window.snap.pay(snapToken, {
                onSuccess: function(result){
                    window.location.href = '/payment-success/' + orderId;
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!");
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    });
</script>
@endsection
