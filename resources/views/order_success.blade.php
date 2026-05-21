@extends('layouts.app')

@section('head')
    <style>
        body {
            background-color: #fcf9f5;
        }
        .success-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .ticket-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(139, 94, 60, 0.1);
            max-width: 450px;
            width: 100%;
            overflow: hidden;
            text-align: center;
            border: 1px solid #f0e6d2;
        }
        .ticket-header {
            background: #8b5e3c;
            color: #fff;
            padding: 40px 20px 30px;
            position: relative;
        }
        .ticket-header::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 100%;
            height: 30px;
            background-image: radial-gradient(circle at 15px 15px, #fff 16px, transparent 17px);
            background-size: 30px 30px;
            background-position: -5px -15px;
            background-repeat: repeat-x;
        }
        .ticket-body {
            padding: 40px 30px 30px;
        }
        .qr-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            margin: 20px auto;
            border: 10px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-radius: 15px;
        }
        .order-code-box {
            background: #fdfaf6;
            border: 2px dashed #d5bdaf;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
        }
        .order-code-text {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 3px;
            color: #4a3228;
            margin: 0;
        }
        .payment-status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 25px;
        }
        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }
        .badge-paid {
            background: #d4edda;
            color: #155724;
        }
        .btn-home {
            background: #4a3228;
            color: #fff;
            border-radius: 50px;
            padding: 14px 30px;
            text-decoration: none;
            display: block;
            margin-top: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            background: #3e2723;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 50, 40, 0.3);
        }
    </style>
@endsection

@section('content')
<div class="success-container">
    <div class="ticket-card">
        <div class="ticket-header">
            <i class="fas fa-check-circle fa-4x mb-3"></i>
            <h4 class="fw-bold mb-0">Order Received!</h4>
            @if($order->status == 'paid')
                <p class="mb-0 opacity-75 small mt-1">Thank You</p>
            @else
                <p class="mb-0 opacity-75 small mt-1">Please complete your payment</p>
            @endif
        </div>
        <div class="ticket-body">
            @if($order->status == 'paid')
                <span class="payment-status-badge badge-paid">
                    STATUS: PAYMENT SUCCESSFUL
                </span>
                
                <h5 class="fw-bold text-dark mb-3">Order is Being Processed</h5>
                <p class="text-muted small px-3">We have received your order and our Barista is preparing it. Please wait for your name to be called or present this receipt to the cashier if necessary.</p>
                
                <div class="order-code-box mt-4">
                    <small class="text-muted d-block mb-1">ORDER CODE</small>
                    <div class="order-code-text">{{ $order->kode_pesanan }}</div>
                </div>
                <p class="mb-0 fw-bold fs-5 text-success">Paid: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
            
            @else
                <span class="payment-status-badge badge-pending">
                    STATUS: PENDING PAYMENT
                </span>

                @if($order->payment_method == 'qris')
                    <h5 class="fw-bold text-dark mt-3">Online Payment</h5>
                    <p class="text-muted small">Please complete your order payment using the button below.</p>
                    
                    <h3 class="fw-bold text-danger mb-4 mt-3">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h3>

                    @if(isset($snapToken))
                        <button id="pay-button" class="btn btn-primary" style="background: #00A5CF; border: none; padding: 12px 30px; border-radius: 50px; font-weight: bold; font-size: 1.1rem; width: 100%;">
                            <i class="fas fa-wallet me-2"></i> Pay Now
                        </button>
                    @endif
                    <p class="small text-muted mt-3">Automatically verified after payment.</p>
                @endif
            @endif

            <hr class="my-4" style="border-color: #f0e6d2;">
            
            <a href="{{ url('/menu') }}" class="btn-home">
                <i class="fas fa-utensils me-2"></i> Order Again
            </a>
            <div class="mt-4">
                <a href="{{ url('/') }}" class="text-muted small text-decoration-none hover-underline">Back to Home</a>
            </div>
        </div>
    </div>
</div>

@if(isset($snapToken))
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').onclick = function(){
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                window.location.href = '{{ url("/payment-success/" . $order->id) }}';
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
    };
</script>
@endif

@endsection
